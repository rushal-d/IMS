<?php

namespace App\Traits;

use App\BankMerger;
use App\Deposit;
use App\FiscalYear;
use App\Helpers\BSDateHelper;
use App\InvestmentInstitution;
use App\UserOrganization;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Config;

trait DepositTrait
{

    public function getDepositRecord($institution_id, $fiscal_year_id, $start_date_en, $end_date_en, $status_array, $earmarked, $fd_location, $staff_id, $branch_id,
                                     $mature_days, $fd_number, $include_pending, $invstment_sub_type_id, $organization_branch_id)
    {
        $selectedFiscalYear = FiscalYear::find($fiscal_year_id);
        $userOrganization = UserOrganization::first();
        $deposits = Deposit::query();
        if ($include_pending) {
            $deposits->withoutGlobalScope('is_pending');
        }
        if (!empty($fiscal_year_id) && empty($start_date_en)) {
            if (!empty($selectedFiscalYear)) {
                $deposits = $deposits->where(function ($query) use ($selectedFiscalYear) {
                    $query->where([['trans_date_en', '>=', $selectedFiscalYear->start_date_en], ['mature_date_en', '<=', $selectedFiscalYear->end_date_en]]);
                    $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->start_date_en], ['mature_date_en', '>=', $selectedFiscalYear->start_date_en]]);
                    $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->end_date_en], ['mature_date_en', '>=', $selectedFiscalYear->end_date_en]]);
                    $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->start_date_en], ['mature_date_en', '>=', $selectedFiscalYear->end_date_en]]);
                });
            }
        }
        if (!empty($start_date_en)) {
            if (empty($end_date_en)) {
                $end_date_en = date('Y-m-d');
            }
            $deposits = $deposits->where(function ($query) use ($start_date_en, $end_date_en) {
                $query->where([['trans_date_en', '>=', $start_date_en], ['mature_date_en', '<=', $end_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $start_date_en], ['mature_date_en', '>=', $start_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $end_date_en], ['mature_date_en', '>=', $end_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $start_date_en], ['mature_date_en', '>=', $end_date_en]]);
            });
        }
        if (!empty($status_array) && count($status_array) > 0) {
            /*if ($input['status'] == 1) {
                   $deposits = $deposits->whereDate('mature_date_en', '>=', date('Y-m-d'));
               } elseif ($input['status'] == 2) {
                   $deposits->whereRaw('mature_date_en >= CURDATE() and `alert_days` >= (datediff(CURDATE() , DATE(mature_date_en))) and alert_days >= datediff(DATE(mature_date_en), CURDATE())');
               } elseif ($input['status'] == 3) {
                   $deposits = $deposits->whereDate('mature_date_en', '<', date('Y-m-d'));
               } else {
                   $deposits = $deposits->where('status', $input['status']);
               }*/
            $deposits = $deposits->whereIn('status', $status_array);
            if (count($status_array) == 1) {
                if ($status_array[0] == 2 || $status_array[0] == 3) {
                    $deposits = $deposits->orderBy('mature_date_en');
                }
            }
        }
        if (!empty($institution_id)) {
            $deposits = $deposits->where('institution_id', '=', $institution_id);
        }
        if (!empty($invstment_sub_type_id)) {
            $deposits = $deposits->where('investment_subtype_id', '=', $invstment_sub_type_id);
        }
        if (!empty($earmarked)) {
            $deposits = $deposits->where('earmarked', '=', $earmarked);
        }
        if (!empty($fd_location)) {
            $deposits = $deposits->where('fd_document_current_location', '=', $fd_location);
        }
        if (!empty($organization_branch_id)) {
            $deposits = $deposits->where('organization_branch_id', '=', $organization_branch_id);
        }
        if (!empty($staff_id)) {
            $deposits = $deposits->where('staff_id', '=', $staff_id);
        }
        if (!empty($branch_id)) {
            $deposits = $deposits->where('branch_id', $branch_id);
        }
        if (!empty($mature_days)) {
            $deposits = $deposits->whereDate('mature_date_en', '>=', date('Y-m-d'))->whereDate('mature_date_en', '<=', date('Y-m-d', strtotime('+' . $mature_days . 'days')));
        }
        if (!empty($fd_number)) {
            $fd_number = trim($fd_number);
            $deposits = $deposits->where('document_no', 'like', '%' . $fd_number . '%');
        }

        $acquiredDeposits = [];
        if ($userOrganization->implement_merger == 1 && (!empty($institution_id) || !empty($invstment_sub_type_id))) {
            $acquiredDeposits = self::getAcquiredDepositsAfterMerger($institution_id, $fiscal_year_id, $start_date_en, $end_date_en, $status_array, $earmarked, $fd_location, $staff_id, $branch_id,
                $mature_days, $fd_number, $include_pending, $invstment_sub_type_id, $organization_branch_id);
        }
        if (count($acquiredDeposits) > 0) {
            $deposits = $deposits->orWhereIn('id', $acquiredDeposits);
        }

        if ($userOrganization->organization_code == '0415') {
            $deposits = $deposits
                ->orderByRaw('CAST(reference_number AS DECIMAL(10,2))');
            $deposits = $deposits
                ->orderBy('id');
        }

        //paginated deposit after filter with all required relations to view on index
        $deposits = $deposits->with(['child' => function ($query) use ($fiscal_year_id, $start_date_en, $end_date_en, $include_pending, $selectedFiscalYear) {

            if (!empty($fiscal_year_id) && !empty($selectedFiscalYear) && empty($start_date_en)) {
                $query->where([['trans_date_en', '>=', $selectedFiscalYear->start_date_en], ['mature_date_en', '<=', $selectedFiscalYear->end_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->start_date_en], ['mature_date_en', '>=', $selectedFiscalYear->start_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->end_date_en], ['mature_date_en', '>=', $selectedFiscalYear->end_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->start_date_en], ['mature_date_en', '>=', $selectedFiscalYear->end_date_en]]);
            }

            if (!empty($start_date_en)) {
                if (empty($end_date_en)) {
                    $end_date_en = date('Y-m-d');
                }
                $query->where([['trans_date_en', '>=', $start_date_en], ['mature_date_en', '<=', $end_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $start_date_en], ['mature_date_en', '>=', $start_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $end_date_en], ['mature_date_en', '>=', $end_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $start_date_en], ['mature_date_en', '>=', $end_date_en]]);
            }
            if ($include_pending) {
                $query->withoutGlobalScope('is_pending');
            }
        }, 'institute' => function ($query) {
            $query->with('mergedTo');
        }, 'bank', 'branch', 'deposit_type', 'fiscalyear', 'withdraw' => function ($query) use ($fiscal_year_id, $start_date_en, $end_date_en, $selectedFiscalYear) {
            if (!empty($fiscal_year_id) && !empty($selectedFiscalYear) && empty($start_date_en)) {
                if (!empty($selectedFiscalYear)) {
                    $query->where('withdrawdate_en', '>=', $selectedFiscalYear->start_date_en);
                    $query->where('withdrawdate_en', '<=', $selectedFiscalYear->end_date_en);
                }
            }

            if (!empty($start_date_en)) {
                if (empty($end_date_en)) {
                    $end_date_en = date('Y-m-d');
                }
                $query->where('withdrawdate_en', '>=', $start_date_en);
                $query->where('withdrawdate_en', '<=', $end_date_en);
            }
        }, 'actualEarning', 'bankMerger'])->where(function ($query) use ($fiscal_year_id, $end_date_en, $institution_id, $invstment_sub_type_id, $selectedFiscalYear) {
            if (!empty($institution_id) || !empty($invstment_sub_type_id)) {
                $query->where('bank_merger_id', null);
                $query->orWhere(function ($query) use ($fiscal_year_id, $end_date_en, $institution_id, $invstment_sub_type_id, $selectedFiscalYear) {
                    $query->whereHas('bankMerger', function ($query) use ($fiscal_year_id, $end_date_en, $institution_id, $invstment_sub_type_id, $selectedFiscalYear) {
                        $end_date_check = date('Y-m-d');
                        if (!empty($end_date_en)) {
                            $end_date_check = $end_date_en;
                        } else {
                            if (!empty($selectedFiscalYear)) {
                                $end_date_check = $selectedFiscalYear->end_date_en;
                            }
                        }


                        $query->whereHas('mergedToInstitution', function ($innerQuery) use ($institution_id, $invstment_sub_type_id, $end_date_check, $query) {
                            if (!empty($institution_id)) {
                                $innerQuery->where('id', '<>', $institution_id);
                            }
                            if (!empty($invstment_sub_type_id)) {
                                $innerQuery->where('invest_subtype_id', '<>', $invstment_sub_type_id);
                            }
                            $query->whereDate('merger_date', '>', $end_date_check);
                        });

                        $query->whereHas('mergedToInstitution', function ($innerQuery) use ($institution_id, $invstment_sub_type_id, $end_date_check, $query) {
                            if (!empty($institution_id)) {
                                $innerQuery->where('id', $institution_id);
                            }
                            if (!empty($invstment_sub_type_id)) {
                                $innerQuery->where('invest_subtype_id', $invstment_sub_type_id);
                            }
                            $query->orWhereDate('merger_date', '<=', $end_date_check);
                        });
                    });

                });
            }

        })->get();
        $details = array(); //inorder to store the new deposit collections with the child deposits i.e renewed just after it
        $deposits_appeared = array(); //check if the deposit has already appared on the child list of previous deposit

        foreach ($deposits as $deposit) {
            //recursive function inorder to place the deposits together with renew
            $this->add_to_array($details, $deposits, $deposit, $deposits_appeared);
        }
        return [
            'deposits' => $deposits,
            'details' => $details,
        ];

    }

    public function add_to_array(&$details, $deposits, $deposit, &$deposits_appeared)
    {
        if (!array_search($deposit->id, $deposits_appeared)) { //check if already appeared in array
            if (empty($deposit->parent_id)) {
                $details[] = $deposit;
                $deposits_appeared[] = $deposit->id;
            } else {
                $temp_deposit = $deposits->where('id', $deposit->id)->first();
                $deposit = $temp_deposit;
                if (!empty($deposit)) {
                    $details[] = $deposit;
                    $deposits_appeared[] = $deposit->id;
                }
            }
            if (!empty($deposit->child)) {
                $this->add_to_array($details, $deposits, $deposit->child, $deposits_appeared);
            }
        }
    }

    public function mergerTest($bank_code, $end_date_to_check)
    {
        $to_include = BankMerger::where('bank_code_after_merger', $bank_code)->where('merger_date', '<=', $end_date_to_check)->pluck('id')->toArray();
        $toExclude = BankMerger::whereHas('mergeBankList', function ($query) use ($bank_code) {
            $query->where('bank_code', $bank_code);
        })->where('merger_date', '<=', $end_date_to_check)->pluck('id')->toArray();
        $toExclude = array_diff($toExclude, $to_include);
        return [
            'toInclude' => $to_include,
            'toExclude' => $toExclude,
        ];
    }

    public static function getAcquiredDepositsAfterMerger($institution_id, $fiscal_year_id, $start_date_en, $end_date_en, $status_array, $earmarked, $fd_location, $staff_id, $branch_id,
                                                          $mature_days, $fd_number, $include_pending, $invstment_sub_type_id, $organization_branch_id)
    {

        $bank_merger = BankMerger::query();

        if (!empty($institution_id) || !empty($invstment_sub_type_id)) {
            $bank_merger = $bank_merger->whereHas('mergedToInstitution', function ($query) use ($institution_id, $invstment_sub_type_id) {
                if (!empty($institution_id)) {
                    $query->where('id', $institution_id);
                }
                if (!empty($invstment_sub_type_id)) {
                    $query->where('invest_subtype_id', $invstment_sub_type_id);
                }
            });
        }

        if (!empty($end_date_en)) {
            $bank_merger = $bank_merger->where('merger_date', '<=', $end_date_en);
        }

        $bank_merger = $bank_merger->get();
        $merger_ids = $bank_merger->pluck('id')->toArray();

        $deposits = Deposit::query();
        if ($include_pending) {
            $deposits->withoutGlobalScope('is_pending');
        }
        $selectedFiscalYear = FiscalYear::find($fiscal_year_id);
        if (!empty($fiscal_year_id) && empty($start_date_en)) {
            if (!empty($selectedFiscalYear)) {
                $deposits = $deposits->where(function ($query) use ($selectedFiscalYear) {
                    $query->where([['trans_date_en', '>=', $selectedFiscalYear->start_date_en], ['mature_date_en', '<=', $selectedFiscalYear->end_date_en]]);
                    $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->start_date_en], ['mature_date_en', '>=', $selectedFiscalYear->start_date_en]]);
                    $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->end_date_en], ['mature_date_en', '>=', $selectedFiscalYear->end_date_en]]);
                    $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->start_date_en], ['mature_date_en', '>=', $selectedFiscalYear->end_date_en]]);
                });
            }
        }

        if (!empty($start_date_en)) {
            if (empty($end_date_en)) {
                $end_date_en = date('Y-m-d');
            }
            $deposits = $deposits->where(function ($query) use ($start_date_en, $end_date_en) {
                $query->where([['trans_date_en', '>=', $start_date_en], ['mature_date_en', '<=', $end_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $start_date_en], ['mature_date_en', '>=', $start_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $end_date_en], ['mature_date_en', '>=', $end_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $start_date_en], ['mature_date_en', '>=', $end_date_en]]);
            });
        }


        if (!empty($status_array) && count($status_array) > 0) {
            $deposits = $deposits->whereIn('status', $status_array);
        }

        if (!empty($earmarked)) {
            $deposits = $deposits->where('earmarked', '=', $earmarked);
        }

        if (!empty($fd_location)) {
            $deposits = $deposits->where('fd_document_current_location', '=', $fd_location);
        }

        if (!empty($organization_branch_id)) {
            $deposits = $deposits->where('organization_branch_id', '=', $organization_branch_id);
        }
        if (!empty($staff_id)) {
            $deposits = $deposits->where('staff_id', '=', $staff_id);
        }
        if (!empty($branch_id)) {
            $deposits = $deposits->where('branch_id', $branch_id);
        }
        if (!empty($mature_days)) {
            $deposits = $deposits->whereDate('mature_date_en', '>=', date('Y-m-d'))->whereDate('mature_date_en', '<=', date('Y-m-d', strtotime('+' . $mature_days . 'days')));
        }
        if (!empty($fd_number)) {
            $fd_number = trim($fd_number);
            $deposits = $deposits->where('document_no', 'like', '%' . $fd_number . '%');
        }
        $deposits = $deposits->whereIn('bank_merger_id', $merger_ids);
        $deposit_ids = $deposits->pluck('id')->toArray();

        return $deposit_ids;
    }

    public static function excelDownload($data)
    {

        return Excel::create('Deposit Excel', function ($excel) use ($data) {
            $excel->sheet('Deposits', function ($sheet) use ($data) {
                $columnFormatArray = [];
                $opening_column = $renew_column = $withdraw_column = '';
                $lgi_fd_amount_total = $lgi_fd_withdraw_total = 0;
                $depositExcelFields = Config::get('constants.deposit_export_fields');
                $excel_columns = Config::get('constants.excel_column_title');
                $userOrganization = UserOrganization::first();
                $depositExcelSelected = explode(',', $userOrganization->deposit_excel_columns);
                $column_count = 0;
                if (in_array(array_search('SN', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('SN')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if ($userOrganization->organization_code == '0415') {
                    if (in_array(array_search('Reference Number', $depositExcelFields), $depositExcelSelected)) {
                        $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                            $cell->setValue('Reference Number')->setFontWeight('bold');
                        });
                        $column_count++;
                    }
                    $sheet->getColumnDimension('AA')->setVisible(false);
                }

                if (in_array(array_search('Fiscal Year', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Fiscal Year')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Bank Name', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Bank Name')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Bank Branch', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Bank Branch')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Organization Branch', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Organization Branch')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('FD No.', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('FD No.')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Interest Rate', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Interest Rate')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Transaction Date', $depositExcelFields), $depositExcelSelected)) {
                    $columnFormatArray[$excel_columns[$column_count]] = 'd-mmm-y';
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Transaction Date')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Transaction Date (BS)', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Transaction Date (BS)')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Duration (days)', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Duration (days)')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Mature Days', $depositExcelFields), $depositExcelSelected)) {
                    $columnFormatArray[$excel_columns[$column_count]] = 'd-mmm-y';
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Mature Days')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Mature Days (BS)', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Mature Days (BS)')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if ($userOrganization->organization_code == '0415') {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('FD Amount')->setFontWeight('bold');
                    });
                    $opening_column = $excel_columns[$column_count];
                    $column_count++;

                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Withdraw Amount')->setFontWeight('bold');
                    });
                    $withdraw_column = $excel_columns[$column_count];
                    $column_count++;
                } else {
                    if (in_array(array_search('Opening Amount', $depositExcelFields), $depositExcelSelected)) {
                        $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                            $cell->setValue('Opening Amount')->setFontWeight('bold');
                        });
                        $opening_column = $excel_columns[$column_count];
                        $column_count++;
                    }

                    if (in_array(array_search('Renew Amount', $depositExcelFields), $depositExcelSelected)) {
                        $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                            $cell->setValue('Renew Amount')->setFontWeight('bold');
                        });
                        $renew_column = $excel_columns[$column_count];
                        $column_count++;
                    }

                    if (in_array(array_search('Withdrawn Amount', $depositExcelFields), $depositExcelSelected)) {
                        $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                            $cell->setValue('Withdrawn Amount')->setFontWeight('bold');
                        });
                        $withdraw_column = $excel_columns[$column_count];
                        $column_count++;
                    }
                }


                if (in_array(array_search('Estimated Earning', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Estimated Earning')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Interest Payment Method', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Interest Payment Method')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Investment Sector', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Investment Sector')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Actual Earning', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Actual Earning')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Status', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Status')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Cheque Number', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Cheque Number')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Reference Number', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Reference Number')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Interest Credited Bank', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Interest Credited Bank')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Interest Credited Bank Branch', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Interest Credited Bank Branch')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Account Number', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Account Number')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Notes', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Notes')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Receipt Number', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Receipt Number')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Staff Name', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Staff Name')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Credit Date', $depositExcelFields), $depositExcelSelected)) {
                    $columnFormatArray[$excel_columns[$column_count]] = 'd-mmm-y';
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Credit Date')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Credit Date (BS)', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Credit Date (BS)')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Cheque Date', $depositExcelFields), $depositExcelSelected)) {
                    $columnFormatArray[$excel_columns[$column_count]] = 'd-mmm-y';
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Cheque Date')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Cheque Date (BS)', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Cheque Date (BS)')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Narration', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Narration')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Voucher Number', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Voucher Number')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('FD Current Location', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('FD Current Location')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Bank Contact Person', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Bank Contact Person')->setFontWeight('bold');
                    });
                    $column_count++;
                }

                if (in_array(array_search('Earmarked', $depositExcelFields), $depositExcelSelected)) {
                    $sheet->cell($excel_columns[$column_count] . '1', function ($cell) {
                        $cell->setValue('Earmarked')->setFontWeight('bold');
                    });
                    $column_count++;
                }


                $sheet->setColumnFormat($columnFormatArray);

                if (!empty($data)) {
                    $i = 1;
                    $opening_amount = 0;
                    $renewed_amount = 0;
                    $withdrawn_amount = 0;
                    foreach ($data as $value) {
                        $i = $i + 1;
                        $sheet->setBorder('A' . $i . ':' . $excel_columns[count($depositExcelSelected) - 1] . $i, 'thin');
                        if (empty($value->parent_id)) {
                            $opening_amount += $value->deposit_amount;
                        } else {
                            $renewed_amount += $value->deposit_amount;
                        }

                        if (!empty($value->withdraw) || ($value->status == 4 && !empty($value->child))) {
                            $withdrawn_amount += $value->deposit_amount;
                        }
                        $status = '';
                        if ($value->is_pending == 1) {
                            $status = 'Pending';
                        } else {
                            if ($value->status == 1) {
                                if (!empty($value->parent_id)) {
                                    $status = 'Renewed & Active';
                                } else {
                                    $status = 'Active';
                                }

                            } elseif ($value->status == 2) {
                                $status = 'Renew Soon';
                            } elseif ($value->status == 3) {
                                $status = 'Expired';
                            } elseif ($value->status == 4) {
                                $status = 'Expired & Has Been Renewed';
                            } else {
                                $status = 'WithDrawn';
                            }
                        }

                        $column_count = 0;
                        if (in_array(array_search('SN', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, $i - 1);
                            $column_count++;
                        }

                        if ($userOrganization->organization_code == '0415') {
                            if (in_array(array_search('Reference Number', $depositExcelFields), $depositExcelSelected)) {
                                $sheet->cell($excel_columns[$column_count] . $i, $value->reference_number ?? '');
                                $column_count++;
                            }
                        }

                        if (in_array(array_search('Fiscal Year', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, $value->fiscalyear->code ?? '');
                            $column_count++;
                        }

                        if (in_array(array_search('Bank Name', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, $value->institute->institution_name ?? 'N/A');
                            $column_count++;
                        }

                        if (in_array(array_search('Bank Branch', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, $value->branch->branch_name ?? 'N/A');
                            $column_count++;
                        }

                        if (in_array(array_search('Organization Branch', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, $value->organization_branch->branch_name ?? 'N/A');
                            $column_count++;
                        }

                        if (in_array(array_search('FD No.', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, "'" . $value->document_no);
                            $column_count++;
                        }

                        if (in_array(array_search('Interest Rate', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, $value->interest_rate);
                            $column_count++;
                        }

                        if (in_array(array_search('Transaction Date', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, !empty(($value->trans_date_en)) ? self::toUnixTime($value->trans_date_en) : '');
                            $column_count++;
                        }

                        if (in_array(array_search('Transaction Date (BS)', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, (!empty($value->trans_date_en)) ? BSDateHelper::AdToBsEN('-', $value->trans_date_en) : '');
                            $column_count++;
                        }

                        if (in_array(array_search('Duration (days)', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, $value->days);
                            $column_count++;
                        }

                        if (in_array(array_search('Mature Days', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, !empty($value->mature_date_en) ? self::toUnixTime($value->mature_date_en) : '');
                            $column_count++;
                        }

                        if (in_array(array_search('Mature Days (BS)', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, !empty($value->mature_date_en) ? BSDateHelper::AdToBsEN('-', $value->mature_date_en) : '');
                            $column_count++;
                        }

                        if ($userOrganization->organization_code == '0415') {
                            $sheet->cell($excel_columns[$column_count] . $i, (!empty($value->child)) ? 0 : $value->deposit_amount);
                            $lgi_fd_amount_total += (!empty($value->child)) ? 0 : $value->deposit_amount;
                            $column_count++;

                            $sheet->cell($excel_columns[$column_count] . $i, (empty($value->withdraw)) ? 0 : $value->deposit_amount);
                            $lgi_fd_withdraw_total += (empty($value->withdraw)) ? 0 : $value->deposit_amount;
                            $column_count++;

                        } else {
                            if (in_array(array_search('Opening Amount', $depositExcelFields), $depositExcelSelected)) {
                                $sheet->cell($excel_columns[$column_count] . $i, (empty($value->parent_id)) ? $value->deposit_amount : '');
                                $column_count++;
                            }

                            if (in_array(array_search('Renew Amount', $depositExcelFields), $depositExcelSelected)) {
                                $sheet->cell($excel_columns[$column_count] . $i, (!empty($value->parent_id)) ? $value->deposit_amount : '');
                                $column_count++;
                            }

                            if (in_array(array_search('Withdrawn Amount', $depositExcelFields), $depositExcelSelected)) {
                                $sheet->cell($excel_columns[$column_count] . $i, (!empty($value->withdraw) || ($value->status == 4 && !empty($value->child))) ? $value->deposit_amount : '');
                                $column_count++;
                            }
                        }


                        if (in_array(array_search('Estimated Earning', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, $value->estimated_earning);
                            $column_count++;
                        }

                        if (in_array(array_search('Interest Payment Method', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, Config::get('constants.investment_payment_methods')[$value->interest_payment_method ?? ''] ?? '');
                            $column_count++;
                        }

                        if (in_array(array_search('Investment Sector', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, $value->deposit_type->name ?? 'N/A');
                            $column_count++;
                        }

                        if (in_array(array_search('Actual Earning', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, $value->actualEarning->sum('amount') ?? '');
                            $column_count++;
                        }

                        if (in_array(array_search('Status', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, $status);
                            $column_count++;
                        }

                        if (in_array(array_search('Cheque Number', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, $value->cheque_no);
                            $column_count++;
                        }

                        if (in_array(array_search('Reference Number', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, $value->reference_number ?? '');
                            $column_count++;
                        }

                        if (in_array(array_search('Interest Credited Bank', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, $value->bank->institution_name ?? '');
                            $column_count++;
                        }

                        if (in_array(array_search('Interest Credited Bank Branch', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, $value->bank_branch->branch_name ?? '');
                            $column_count++;
                        }

                        if (in_array(array_search('Account Number', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, $value->accountnumber);
                            $column_count++;
                        }

                        if (in_array(array_search('Notes', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, $value->notes);
                            $column_count++;
                        }

                        if (in_array(array_search('Receipt Number', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, $value->receipt_no);

                            $column_count++;
                        }

                        if (in_array(array_search('Staff Name', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, $value->staff->name ?? '');
                            $column_count++;
                        }

                        if (in_array(array_search('Credit Date', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, (!empty($value->credit_date) ? self::toUnixTime($value->credit_date) : ''));
                            $column_count++;
                        }

                        if (in_array(array_search('Credit Date (BS)', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, (!empty($value->credit_date) ? BSDateHelper::AdToBsEN('-', $value->credit_date) : ''));
                            $column_count++;
                        }

                        if (in_array(array_search('Cheque Date', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, $value->cheque_date ?? '');
                            $column_count++;
                        }

                        if (in_array(array_search('Cheque Date (BS)', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, $value->cheque_date_np ?? '');
                            $column_count++;
                        }

                        if (in_array(array_search('Narration', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, $value->narration ?? '');
                            $column_count++;
                        }

                        if (in_array(array_search('Voucher Number', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, $value->voucher_number ?? '');
                            $column_count++;
                        }

                        if (in_array(array_search('FD Current Location', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, Config::get('constants.fd_document_lcoations')[$value->fd_document_current_location ?? ''] ?? '');
                            $column_count++;
                        }

                        if (in_array(array_search('Bank Contact Person', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, $value->bank_contact_person ?? '');
                            $column_count++;
                        }

                        if (in_array(array_search('Earmarked', $depositExcelFields), $depositExcelSelected)) {
                            $sheet->cell($excel_columns[$column_count] . $i, ($value->earmarked == 1) ? 'Earmarked' : '');
                            $column_count++;
                        }
                    }

                    $to = $i + 1;

                    if ($userOrganization->organization_code == '0415') {
                        $sheet->cell($opening_column . $to, $lgi_fd_amount_total);
                        $sheet->cell($withdraw_column . $to, $lgi_fd_withdraw_total);
                    } else {
                        if ($opening_column != '') {
                            $sheet->cell($opening_column . $to, $opening_amount);
                        }
                        if ($renew_column != '') {
                            $sheet->cell($renew_column . $to, $renewed_amount);
                        }
                        if ($withdraw_column != '') {
                            $sheet->cell($withdraw_column . $to, $withdrawn_amount);
                        }


                        $sheet->cell('R' . ($to + 1), function ($cell) {
                            $cell->setValue('Total Amount')->setFontWeight('bold');
                        });
                        $sheet->mergeCells('S' . ($to + 1) . ':U' . ($to + 1));
                        $sheet->cell('S' . ($to + 1), $opening_amount + $renewed_amount - $withdrawn_amount);
                    }

                }
            });
        })->download('xlsx');
    }

    public static function toUnixTime($date)
    {
        $strtotime = strtotime($date);
        $unix_time = ($strtotime / 86400) + 25569;
        return round($unix_time);
    }
}