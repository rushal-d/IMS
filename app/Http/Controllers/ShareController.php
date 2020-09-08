<?php

namespace App\Http\Controllers;

use App\BonusShareHistory;
use App\Console\Commands\PullShareHistory;
use App\FiscalYear;
use App\Helpers\BSDateHelper;
use App\InvestmentInstitution;
use App\InvestmentSubType;
use App\InvestmentType;
use App\Share;
use App\ShareMarketToday;
use App\SharePullDateRecord;
use App\ShareRecord;
use Goutte\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class ShareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $shares = new Share;
        $openingBalanceShare = new Share;
        $input = Input::all();
        $previousClosingDate = null;
        if (!empty($request->fiscal_year_id)) {
            $shares = $shares->where('fiscal_year_id', $request->fiscal_year_id);
            $previousClosingDate = FiscalYear::where('id', $request->fiscal_year_id)->first()->start_date_en ?? null;
        }

        if (!empty($input['institution_code'])) {
            $shares = $shares->where('institution_code', $input['institution_code']);
            $openingBalanceShare = $openingBalanceShare->where('institution_code', $input['institution_code']);
        }

        if (!empty($input['start_date'])) {
            $shares = $shares->where('trans_date_en', '>=', $input['start_date']);
            $previousClosingDate = $input['start_date'];
        }
        if (!empty($input['end_date'])) {
            $shares = $shares->where('trans_date_en', '<=', $input['end_date']);
        }
        if (!empty($input['investment_subtype_id'])) {
            $shares = $shares->where('investment_subtype_id', $input['investment_subtype_id']);
            $openingBalanceShare = $openingBalanceShare->where('investment_subtype_id', $input['investment_subtype_id']);
        }
        if (!empty($input['share_type'])) {
            $shares = $shares->where('share_type_id', $input['share_type']);
            $openingBalanceShare = $openingBalanceShare->where('share_type_id', $input['share_type']);
        }
        $openingBalanceShare2 = clone($openingBalanceShare);
        if (!empty($previousClosingDate)) {
            $data['openingBalance'] = $openingBalanceShare->where('trans_date_en', '<', $previousClosingDate)->where('share_type_id', '<>', 6)->sum('total_amount') - $openingBalanceShare2->where('trans_date_en', '<', $previousClosingDate)->where('share_type_id', '=', 6)->sum('total_amount');
        } else {
            $data['openingBalance'] = 0;
        }


        $temp_share = clone($shares);
        $temp_share2 = clone($shares);

        $shares = $shares->with('instituteByCode', 'investment_sector', 'fiscalyear')->latest()->paginate(50);

        $data['share_types'] = Config::get('constants.master_share_type');
        $share_id = InvestmentType::InvestmenttypeShare();
        $data['fiscal_years'] = FiscalYear::all();
        $investment = InvestmentType::findOrFail($share_id);
        $data['institutes'] = $investment->invest_inst;
        $data['investment_subtypes'] = $investment->investment_subtype;

        $data['sharetotalamount'] = $temp_share->where('share_type_id', '<>', 6)->sum('total_amount') - $temp_share2->where('share_type_id', '=', 6)->sum('total_amount');
        return view('share.index', $data, compact('shares'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $share_id = InvestmentType::InvestmenttypeShare();
        $data['fiscal_years'] = FiscalYear::all();
        $investment = InvestmentType::findOrFail($share_id);
        $data['institutes'] = $investment->invest_inst;
        $data['investment_subtypes'] = $investment->investment_subtype;
        $data['share_types'] = Config::get('constants.master_share_type');
        return view('share.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $user_id = Auth::user()->id;
        $input['created_by_id'] = $user_id;
        $input['updated_by_id'] = NULL;
        if (!empty($input['trans_date_en'])) {
            $fiscalyear = FiscalYear::whereDate('start_date_en', '<=', $input['trans_date_en'])->whereDate('end_date_en', '>=', $input['trans_date_en'])->latest()->first();
            if (!empty($fiscalyear)) {
                $input['fiscal_year_id'] = $fiscalyear->id;
            }
        }
        $input['invest_group_id'] = InvestmentInstitution::where('institution_code', $input['institution_code'])->where('invest_type_id', 3)->latest()->first()->invest_group_id;
        $status_mesg = Share::create($input);
        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data added successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('share.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Share $share
     * @return \Illuminate\Http\Response
     */
    public function show(Share $share)
    {
        $count = 1;
        $bonus_share_histories = BonusShareHistory::where('share_id', $share->id)->get();
        $data['share_types'] = Config::get('constants.master_share_type');
        return view('share.show', $data, compact('share', 'bonus_share_histories', 'count'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Share $share
     * @return \Illuminate\Http\Response
     */
    public function edit(Share $share)
    {
        $share_id = InvestmentType::InvestmenttypeShare();
        $data['fiscal_years'] = FiscalYear::all();
        $investment = InvestmentType::findOrFail($share_id);
        $data['institutes'] = $investment->invest_inst;
        $data['investment_subtypes'] = $investment->investment_subtype;
        $data['share_types'] = Config::get('constants.master_share_type');
        return view('share.edit', $data, compact('share'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Share $share
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Share $share)
    {
        $input = $request->all();
        $user_id = Auth::user()->id;
        $input['updated_by_id'] = $user_id;
//        if($input['share_type_id'] == 2)
//        {
//            $input['investment_subtype_id'] = 10;
//        }
//        else{
//            $input['investment_subtype_id'] = 9;
//        }
        if (!empty($input['trans_date_en'])) {
            $fiscalyear = FiscalYear::whereDate('start_date_en', '<=', $input['trans_date_en'])->whereDate('end_date_en', '>=', $input['trans_date_en'])->latest()->first();
            if (!empty($fiscalyear)) {
                $input['fiscal_year_id'] = $fiscalyear->id;
            }
        }
        $input['invest_group_id'] = InvestmentInstitution::where('institution_code', $input['institution_code'])->where('invest_type_id', 3)->latest()->first()->invest_group_id;
        $status_mesg = $share->update($input);

        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data updated Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('share.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Share $share
     * @return \Illuminate\Http\Response
     */
    public function destroy(Share $share)
    {
        $share->deleted_by_id = Auth::user()->id;
        $share->save();
        $status_mesg = $share->delete();

        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Deleted Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('share.index')->with($notification);
    }

    public function downloadExcel(Request $request)
    {
        $shares = new Share;
        $input = Input::all();
        if (!empty($request->fiscal_year_id)) {
            $shares = $shares->where('fiscal_year_id', $request->fiscal_year_id);
        }

        if (!empty($input['institution_code'])) {
            $shares = $shares->where('institution_code', $input['institution_code']);
        }

        if (!empty($input['start_date'])) {
            $shares = $shares->where('trans_date_en', '>=', $input['start_date']);
        }
        if (!empty($input['end_date'])) {
            $shares = $shares->where('trans_date_en', '<=', $input['end_date']);
        }
        if (!empty($input['investment_subtype_id'])) {
            $shares = $shares->where('investment_subtype_id', $input['investment_subtype_id']);
        }
        if (!empty($input['share_type'])) {
            $shares = $shares->where('share_type_id', $input['share_type']);
        }
        $shares = $shares->with('instituteByCode', 'investment_sector')->get();

        $data = $shares->sortBy('instituteByCode.institution_name');
        $balance = 0;
        return Excel::create('Share', function ($excel) use ($data, $balance) {
            $excel->sheet('Sheet 1', function ($sheet) use ($data, $balance) {
                $sheet->cell('A1', function ($cell) {
                    $cell->setValue('Fiscal Year')->setFontWeight('bold');
                });
                $sheet->cell('B1', function ($cell) {
                    $cell->setValue('Transaction Date')->setFontWeight('bold');
                });
                $sheet->cell('C1', function ($cell) {
                    $cell->setValue('Organization Name')->setFontWeight('bold');
                });
                $sheet->cell('D1', function ($cell) {
                    $cell->setValue('Investment Sector')->setFontWeight('bold');
                });
                $sheet->cell('E1', function ($cell) {
                    $cell->setValue('No of Kitta')->setFontWeight('bold');
                });
                $sheet->cell('F1', function ($cell) {
                    $cell->setValue('Rate')->setFontWeight('bold');
                });
                $sheet->cell('G1', function ($cell) {
                    $cell->setValue('Dr Amount')->setFontWeight('bold');
                });
                $sheet->cell('H1', function ($cell) {
                    $cell->setValue('Cr Amount')->setFontWeight('bold');
                });
                $sheet->cell('I1', function ($cell) {
                    $cell->setValue('Balance')->setFontWeight('bold');
                });
                $sheet->cell('J1', function ($cell) {
                    $cell->setValue('Type')->setFontWeight('bold');
                });

                if (!empty($data)) {
                    $i = 1;
                    $share_types = Config::get('constants.master_share_type');
                    foreach ($data as $value) {
                        $i = $i + 1;
                        $share_type = $value->share_type_id ?? null;
                        if ($share_type == 6) {
                            $balance -= $value->total_amount;
                        } else {
                            $balance += $value->total_amount;
                        }

                        $sheet->setBorder('A' . $i . ':M' . $i, 'thin');
                        $sheet->cell('A' . $i, $value->fiscalyear->code);
                        $sheet->cell('B' . $i, $value->trans_date);
                        $sheet->cell('C' . $i, $value->instituteByCode->institution_name ?? '');
                        $sheet->cell('D' . $i, $value->investment_sector->name);
                        $sheet->cell('E' . $i, $value->purchase_kitta);
                        $sheet->cell('F' . $i, $value->purchase_value);
                        $sheet->cell('G' . $i, ($share_type != 6) ? $value->total_amount : '');
                        $sheet->cell('H' . $i, ($share_type == 6) ? $value->total_amount : '');
                        $sheet->cell('I' . $i, $balance);
                        $sheet->cell('J' . $i, $share_types[$share_type] ?? '');
                    }
                    $to = $i + 1;
                    $sheet->cell('H' . $to, function ($cell) {
                        $cell->setValue('Total Amount')->setFontWeight('bold');
                    });
                    $sheet->cell('I' . $to, $balance);
                }
            });
        })->download('xlsx');
    }

    public function todaysharemarket()
    {
        $shares = ShareMarketToday::all();
        return view('share.todaysharemarket', compact('shares'));
    }

    public function askclosevalue($institution_code, $date)
    {

        $closing_value_on_date = ShareRecord::whereDate('date', '<=', $date)->where('organization_code', $institution_code)->latest()->first();

        if (!empty($closing_value_on_date)) {
            $org_close = $closing_value_on_date->closing_value;
        } else {
            $org_close = '';
        }
        return response()->json($org_close);
    }

    public function getShareRecords()
    {
        $share_pull_date_record = SharePullDateRecord::latest()->first();
        if (empty($share_pull_date_record)) {
            $input['record_date'] = '2018-07-14';
            $input['number_of_records'] = 0;
            $share_pull_date_record = SharePullDateRecord::create($input);
        }
        $client = new Client();
        $date_to_pull = date('Y-m-d', strtotime($share_pull_date_record->record_date . '+1 Day'));
        if ($date_to_pull < date('Y-m-d')) {
            $crawler = $client->request('GET', 'http://www.nepalstock.com/todaysprice?_limit=500&startDate=' . $date_to_pull);

            $nodeValues = $crawler->filter('table tr')->each(function ($node) {
                return $node->text();
            });
            $status = false;
            $share_related_institutions = InvestmentInstitution::where('invest_type_id', 3)->get();

            try {
                DB::beginTransaction();
                $count_number_of_records = 0; //count number of records on the given date
                foreach ($nodeValues as $nodeValue) {
                    //creating an array of the node record
                    $record = explode("\n", $nodeValue);
                    //trim the white space and removing empty values using array_filter
                    $record = array_filter(array_map('trim', $record));

                    if (count($record) == 10) {
                        if (strcasecmp($record[1], 'S.N.') == 0) {
                            continue;
                        }
                        $institution = $share_related_institutions->where('institution_name', $record[2])->first();
                        if (!empty($institution)) {
                            $input['organization_code'] = $institution->institution_code;
                        }
                        $input['organization_name'] = $record[2];
                        $input['closing_value'] = $record[6];
                        $input['date'] = $date_to_pull;
                        $input['date_np'] = BSDateHelper::AdToBsEN('-', $date_to_pull);
                        ShareRecord::create($input);
                        $count_number_of_records++;
                    }
                }
                $input['record_date'] = $date_to_pull;
                $input['number_of_records'] = $count_number_of_records;
                SharePullDateRecord::create($input);
                $status = true;
            } catch (\Exception $e) {
                DB::rollBack();
                $status = false;
            }
            if ($status) {
                DB::commit();
            }
        }
    }

    public function importExcel(Request $request)
    {
        ini_set('max_execution_time', 180 * 12); //3 minutes
        try {
            $master_share_type = Config::get('constants.master_share_type');
            $completeness = false;
            DB::beginTransaction();
            $path = $request->file('share_excel')->getRealPath();
            $datas = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {
            })->all();
            $fiscal_years = FiscalYear::all();
            foreach ($datas as $data) {
                $input = array();
                if ($data['sn'] == 'END') {
                    break;
                }
                if (!empty($data['previous_institution_code'])) {
                    $check_institution_exists = InvestmentInstitution::where('invest_type_id', 3)->where('institution_code', $data['previous_institution_code'])->first();
                    if (!empty($check_institution_exists)) {
                        $input['previous_institution_code'] = $check_institution_exists->institution_code;
                    } else {
                        if (!empty($data['previous_institution'])) {
                            $new_input['institution_name'] = $data['previous_institution'];
                            $new_input['institution_code'] = $data['previous_institution_code'];
                            $new_input['invest_type_id'] = 3;
                            InvestmentInstitution::create($new_input);
                            $input['previous_institution_code'] = $data['previous_institution_code'];
                        } else {
                            $status = 'error';
                            $mesg = 'Error Occured! Invalid Previous Institution Name on SN.' . $data['sn'] . '!';
                            return $this->errorRedirect($mesg, $status);
                        }
                    }
                }
                $fiscal_year = $fiscal_years->where('start_date_en', '<=', date('Y-m-d', strtotime($data['transaction_date'])))->where('end_date_en', '>=', date('Y-m-d', strtotime($data['transaction_date'])))->first();
                if (!empty($fiscal_year)) {
                    $input['fiscal_year_id'] = $fiscal_year->id;
                } else {
                    $status = 'error';
                    $mesg = 'Error Occured! Invalid date no fiscal year found of this date on SN.' . $data['sn'] . '!';
                    return $this->errorRedirect($mesg, $status);
                }

                if (empty($data['transaction_date'])) {
                    $status = 'error';
                    $mesg = 'Error Occured! Invalid date on SN.' . $data['sn'] . '!';
                    return $this->errorRedirect($mesg, $status);
                } else {
                    $input['trans_date_en'] = date('Y-m-d', strtotime($data['transaction_date']));
                    $input['trans_date'] = BSDateHelper::AdToBsEN('-', $input['trans_date_en']);
                }
                $term = ($data['institution_name']);
                $institution = InvestmentInstitution::whereRaw('lower(institution_name) like (?)', ["{$term}"])->where('invest_type_id', '=', 3)->first();
                if (!empty($institution)) {
                    $input['institution_code'] = $institution->institution_code;
                    $input['invest_group_id'] = $institution->invest_group_id;
                    $input['investment_subtype_id'] = $institution->invest_subtype_id;
                } else {

                    $status = 'error';
                    $mesg = 'Error Occured! Invalid Institution Name on SN.' . $data['sn'] . '!';
                    return $this->errorRedirect($mesg, $status);
                }

                /*$term = strtolower($data['investment_sector']);
                $investment_sector = InvestmentSubType::whereRaw('lower(name) like (?)', ["{$term}"])->where('invest_type_id', 3)->first();
                if (!empty($investment_sector)) {
                    $input['investment_subtype_id'] = $investment_sector->id;
                } else {
                    $status = 'error';
                    $mesg = 'Error Occured! Invalid Investment Sector on SN.' . $data['sn'] . '!';
                    return $this->errorRedirect($mesg, $status);
                }*/

                $share_type_id = array_search(trim($data['share_type']), $master_share_type);
                if ($share_type_id != false) {
                    $input['share_type_id'] = $share_type_id;
                } else {

                    $status = 'error';
                    $mesg = 'Error Occured! Invalid Share Type on SN.' . $data['sn'] . '!';
                    return $this->errorRedirect($mesg, $status);
                }
                $data['kitta'] = abs($data['kitta']);
                if ($data['kitta'] >= 0) {
                    $input['purchase_kitta'] = $data['kitta'];
                } else {
                    $status = 'error';
                    $mesg = 'Error Occured! Invalid Kitta on SN.' . $data['sn'] . '!';
                    return $this->errorRedirect($mesg, $status);
                }
                $data['rate'] = abs($data['rate']);
                $input['kitta_details'] = abs($data['remarks']);
                if ($data['rate'] >= 0) {
                    $input['purchase_value'] = $data['rate'];
                } else {
                    $status = 'error';
                    $mesg = 'Error Occured! Invalid Rate on SN.' . $data['sn'] . '!';
                    return $this->errorRedirect($mesg, $status);
                }
                $input['total_amount'] = $input['purchase_kitta'] * $input['purchase_value'];
                $input['status'] = 1;
                $input['reference_number'] = $data['reference_number'];
                $input['rateperunit'] = ShareRecord::where('organization_code', $input['institution_code'])->where('date', '<=', $data['transaction_date'])->latest()->first()->closing_value ?? 0; //nepse rate on purchase/sale date
                $input['closing_value'] = $input['purchase_kitta'] * $input['rateperunit']; //nepse rate * no of kitta on purchase/sale date

                $input['created_by_id'] = Auth::id();
                Share::create($input);
            }
            $completeness = true;

        } catch (Exception $e) {
            $completeness = false;
            DB::rollBack();
        }
        if ($completeness) {
            DB::commit();
        }
        $status = ($completeness) ? 'success' : 'error';
        $mesg = ($completeness) ? 'Data Uploaded Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('share.index')->with($notification);
    }

    function errorRedirect($mesg, $status)
    {
        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('share.index')->with($notification);
    }

}
