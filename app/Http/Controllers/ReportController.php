<?php

namespace App\Http\Controllers;

use App\AgriTourWaterInvestment;
use App\BankBranch;
use App\Bond;
use App\Deposit;
use App\DepositWithdraw;
use App\FiscalYear;
use App\Helpers\BSDateHelper;
use App\InvestmentGroup;
use App\InvestmentInstitution;
use App\InvestmentSubType;
use App\InvestmentType;
use App\OrganizationBranch;
use App\Share;
use App\TechnicalReserve;
use App\Traits\DepositTrait;
use App\UserOrganization;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    use DepositTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $fiscal_years;
    private $dates = array(
        0 => array(2000, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
        1 => array(2001, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
        2 => array(2002, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
        3 => array(2003, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
        4 => array(2004, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
        5 => array(2005, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
        6 => array(2006, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
        7 => array(2007, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
        8 => array(2008, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 29, 31),
        9 => array(2009, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
        10 => array(2010, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
        11 => array(2011, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
        12 => array(2012, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30),
        13 => array(2013, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
        14 => array(2014, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
        15 => array(2015, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
        16 => array(2016, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30),
        17 => array(2017, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
        18 => array(2018, 31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30),
        19 => array(2019, 31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
        20 => array(2020, 31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30),
        21 => array(2021, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
        22 => array(2022, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30),
        23 => array(2023, 31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
        24 => array(2024, 31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30),
        25 => array(2025, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
        26 => array(2026, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
        27 => array(2027, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
        28 => array(2028, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
        29 => array(2029, 31, 31, 32, 31, 32, 30, 30, 29, 30, 29, 30, 30),
        30 => array(2030, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
        31 => array(2031, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
        32 => array(2032, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
        33 => array(2033, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
        34 => array(2034, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
        35 => array(2035, 30, 32, 31, 32, 31, 31, 29, 30, 30, 29, 29, 31),
        36 => array(2036, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
        37 => array(2037, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
        38 => array(2038, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
        39 => array(2039, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30),
        40 => array(2040, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
        41 => array(2041, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
        42 => array(2042, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
        43 => array(2043, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30),
        44 => array(2044, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
        45 => array(2045, 31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30),
        46 => array(2046, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
        47 => array(2047, 31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30),
        48 => array(2048, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
        49 => array(2049, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30),
        50 => array(2050, 31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
        51 => array(2051, 31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30),
        52 => array(2052, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
        53 => array(2053, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30),
        54 => array(2054, 31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
        55 => array(2055, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
        56 => array(2056, 31, 31, 32, 31, 32, 30, 30, 29, 30, 29, 30, 30),
        57 => array(2057, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
        58 => array(2058, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
        59 => array(2059, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
        60 => array(2060, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
        61 => array(2061, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
        62 => array(2062, 30, 32, 31, 32, 31, 31, 29, 30, 29, 30, 29, 31),
        63 => array(2063, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
        64 => array(2064, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
        65 => array(2065, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
        66 => array(2066, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 29, 31),
        67 => array(2067, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
        68 => array(2068, 31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
        69 => array(2069, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
        70 => array(2070, 31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30),
        71 => array(2071, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
        72 => array(2072, 31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30),
        73 => array(2073, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
        74 => array(2074, 31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30),
        75 => array(2075, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
        76 => array(2076, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30),
        77 => array(2077, 31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
        78 => array(2078, 31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30),
        79 => array(2079, 31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
        80 => array(2080, 31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30),
        81 => array(2081, 31, 31, 32, 32, 31, 30, 30, 30, 29, 30, 30, 30),
        82 => array(2082, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30),
        83 => array(2083, 31, 31, 32, 31, 31, 30, 30, 30, 29, 30, 30, 30),
        84 => array(2084, 31, 31, 32, 31, 31, 30, 30, 30, 29, 30, 30, 30),
        85 => array(2085, 31, 32, 31, 32, 30, 31, 30, 30, 29, 30, 30, 30),
        86 => array(2086, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30),
        87 => array(2087, 31, 31, 32, 31, 31, 31, 30, 30, 29, 30, 30, 30),
        88 => array(2088, 30, 31, 32, 32, 30, 31, 30, 30, 29, 30, 30, 30),
        89 => array(2089, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30),
        90 => array(2090, 30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30));

    public function __construct()
    {
        $fiscal_years = FiscalYear::get();
        $this->fiscal_years = $fiscal_years;
    }

    public function index()
    {
        return redirect()->route('deposit.index');

        $deposit_id = InvestmentType::InvestmenttypeDeposit();
        $data['fiscal_years'] = FiscalYear::all();
        $investment = InvestmentType::findOrFail($deposit_id);
        $data['institutes'] = $investment->invest_inst;
        $data['banks'] = BankBranch::all();
        $data['investment_subtypes'] = $investment->investment_subtype;
        $deposits = Deposit::paginate(20);
        return view('report.index', $data, compact('deposits'));
    }

    public function filter(Request $request)
    {
        $input = $request->all();
        $data['show_index'] = 0;
        if (count($input) > 0) {
            $data['show_index'] = 1;
        }
        $data['fiscal_year_f_id'] = $input['fiscal_year_id'];
        $data['institution_f_id'] = $input['institution_id'];
        $data['deposit_type_f_id'] = $input['investment_subtype_id'];
        $data['status_f'] = $input['status'];
        $data['bank_f_id'] = $input['branch_id'];
        $data['mature_days'] = $input['mature_days'];

        $data['start_date'] = $input['start_date'];
        $data['start_date_en'] = $input['start_date_en'];
        $data['end_date'] = $input['end_date'];
        $data['end_date_en'] = $input['end_date_en'];

        $deposits = Deposit::all();

        if ($input['fiscal_year_id'] != null) {
            $deposits = $deposits->where('fiscal_year_id', $input['fiscal_year_id']);

        }
        if ($input['institution_id'] != null) {
            $deposits = $deposits->where('institution_id', $input['institution_id']);

        }
        if ($input['investment_subtype_id'] != null) {
            $deposits = $deposits->where('investment_subtype_id', $input['investment_subtype_id']);
        }

        if ($input['status'] != null) {
            $deposits = $deposits->where('status', $input['status']);
        }

        if ($input['start_date_en'] != null) {
            $deposits = $deposits->where('trans_date_en', '>=', $input['start_date_en']);
        }

        if ($input['end_date_en'] != null) {
            $deposits = $deposits->where('trans_date_en', '<=', $input['end_date_en']);
        }

        if ($input['branch_id'] != null) {
            $deposits = $deposits->where('branch_id', $input['branch_id']);
        }

        if ($input['mature_days'] != null) {
            if ($input['mature_days'] > 300) {
                $deposits = $deposits->where('days', '>=', $input['mature_days']);
            } else {
                $deposits = $deposits->where('days', '<=', $input['mature_days']);
            }
        }

        $deposit_id = InvestmentType::InvestmenttypeDeposit();
        $data['fiscal_years'] = FiscalYear::all();
        $investment = InvestmentType::findOrFail($deposit_id);
        $data['institutes'] = $investment->invest_inst;
        $data['investment_subtypes'] = $investment->investment_subtype;
        $data['banks'] = BankBranch::all();

        return view('report.index', $data, compact('deposits'));
    }

    public function interest_caluculation(Request $request)
    {
        ini_set('max_execution_time', 180 * 12); //3 minutes
        $userOrganization = UserOrganization::first();
        $fiscals = $this->fiscal_years;
        $data['fiscal_years'] = $fiscals;
        $input = Input::all();
        $data['show_index'] = 0;
        $deposit_id = InvestmentType::InvestmenttypeDeposit();
        $investment = InvestmentType::findOrFail($deposit_id);
        $data['institutes'] = $investment->invest_inst;
        $data['investment_subtypes'] = $investment->investment_subtype;
        //hide table data if no filters
        if (count($input) > 0) {
            $data['show_index'] = 1;
            $data['deposits'] = $this->interest_calculation_filter($request->fiscal_year_id, $request->interest_start_date_en, $request->interest_end_date_en, $request->investment_subtype_id, $fiscals);
        }
        $data['printRecord'] = false;
        if (!empty($userOrganization) && $userOrganization->organization_code == '0415') {
            return view('report.lgi.interest-calculation-report', $data);
        }
        return view('report.interest_calculation', $data);
    }

    public function interest_caluculation_print(Request $request)
    {
        ini_set('max_execution_time', 180 * 12); //3 minutes
        $userOrganization = UserOrganization::first();
        $fiscals = $this->fiscal_years;
        $data['fiscal_years'] = $fiscals;
        $input = Input::all();
        $deposit_id = InvestmentType::InvestmenttypeDeposit();
        $investment = InvestmentType::findOrFail($deposit_id);
        $data['institutes'] = $investment->invest_inst;
        $data['investment_subtypes'] = $investment->investment_subtype;

        $data['show_index'] = 0;
        //hide table data if no filters
        if (count($input) > 0) {
            $data['show_index'] = 1;
            $data['deposits'] = $this->interest_calculation_filter($request->fiscal_year_id, $request->interest_start_date_en, $request->interest_end_date_en, $request->investment_subtype_id, $fiscals);

            $data['printRecord'] = true;
            if (!empty($userOrganization) && $userOrganization->organization_code == '0415') {
                return view('report.lgi.interest-calculation-report-table', $data);
            }
        }

        return view('report.interest-calculation-print', $data);
    }

    public function interest_caluculation_excel(Request $request)
    {
        $userOrganization = UserOrganization::first();

        $fiscals = FiscalYear::get();
        $data['fiscal_years'] = $fiscals;
        $input = Input::all();
        $data['show_index'] = 0;
        if (count($input) > 0) {
            $data['show_index'] = 1;
        }
        $details = $this->interest_calculation_filter($request->fiscal_year_id, $request->interest_start_date_en, $request->interest_end_date_en, $request->investment_subtype_id, $fiscals);
        $data['printRecord'] = false;
        if (!empty($userOrganization) && $userOrganization->organization_code == '0415') {
            $data['deposits'] = $details;
            Excel::create('Deposit Interest Calculation', function ($excel) use ($data) {
                $excel->sheet('Deposit Interest Calculation', function ($sheet) use ($data) {
                    $sheet->freezeFirstRow();
                    $sheet->loadView('report.lgi.interest-calculation-report-table', $data);
                });

            })->download('xlsx');
        }

        return Excel::create('Interest Calculation Report' . date('Y-m-d'), function ($excel) use ($details) {
            $excel->sheet('mySheet', function ($sheet) use ($details) {
                $sheet->cell('A1', function ($cell) {
                    $cell->setValue('Fiscal Year')->setFontWeight('bold');
                });
                $sheet->cell('B1', function ($cell) {
                    $cell->setValue('Start Date')->setFontWeight('bold');
                });
                $sheet->cell('C1', function ($cell) {
                    $cell->setValue('Mature Date')->setFontWeight('bold');
                });
                $sheet->cell('D1', function ($cell) {
                    $cell->setValue('Bank')->setFontWeight('bold');
                });
                $sheet->cell('E1', function ($cell) {
                    $cell->setValue('Deposit Type')->setFontWeight('bold');
                });
                $sheet->cell('F1', function ($cell) {
                    $cell->setValue('Duration (days)')->setFontWeight('bold');
                });
                $sheet->cell('G1', function ($cell) {
                    $cell->setValue('FD Number')->setFontWeight('bold');
                });
                $sheet->cell('H1', function ($cell) {
                    $cell->setValue('Deposit Amount')->setFontWeight('bold');
                });

                $sheet->cell('I1', function ($cell) {
                    $cell->setValue('Interest Rate')->setFontWeight('bold');
                });
                $sheet->cell('J1', function ($cell) {
                    $cell->setValue('Estimated Earning')->setFontWeight('bold');
                });
                $sheet->cell('K1', function ($cell) {
                    $cell->setValue('Interest Calculation Start')->setFontWeight('bold');
                });
                $sheet->cell('L1', function ($cell) {
                    $cell->setValue('Interest Calculation End')->setFontWeight('bold');
                });
                $sheet->cell('M1', function ($cell) {
                    $cell->setValue('Status')->setFontWeight('bold');
                });

                if (!empty($details)) {
                    $i = 1;
                    $total = 0;
                    foreach ($details as $detail) {
                        $i = $i + 1;
                        $sheet->setBorder('A' . $i . ':M' . $i, 'thin');
                        $total += $detail['deposit_amount'];
                        $sheet->cell('A' . $i, $detail['fiscal_code']);
                        $sheet->cell('B' . $i, date('d-M-Y', strtotime($detail['trans_date_en'])));
                        $sheet->cell('C' . $i, date('d-M-Y', strtotime($detail['mature_date_en'])));
                        $sheet->cell('D' . $i, $detail['institution_name'] . ',' . $detail['branch_name']);
                        $sheet->cell('E' . $i, $detail['deposit_type']);
                        $sheet->cell('F' . $i, $detail['days']);
                        $sheet->cell('G' . $i, $detail['fd_number']);
                        $sheet->cell('H' . $i, $detail['deposit_amount']);
                        $sheet->cell('I' . $i, $detail['interest_rate']);
                        $sheet->cell('J' . $i, $detail['estimated_earning']);
                        $sheet->cell('K' . $i, $detail['interest_start']);
                        $sheet->cell('L' . $i, $detail['interest_end']);

                        if ($detail['status'] == 1) {
                            $sta = 'Active';
                        } elseif ($detail['status'] == 2) {
                            $sta = 'Renew Soon';
                        } else {
                            $sta = 'Expired';
                        }
                        $sheet->cell('M' . $i, $sta);
                    }
                    /* $to = $i + 1;
                     $sheet->cell('G' . $to, function ($cell) {
                         $cell->setValue('Total Amount')->setFontWeight('bold');
                     });
                     $sheet->cell('H' . $to, $total);*/
                }
            });
        })->download('xlsx');
    }

    public function fiscal_split(&$data, $trans_start, $trans_end, $filter_end_date)
    {
        $fiscal_datas = $this->fiscal_years;
        $i = count($data);
        $fiscals = $fiscal_datas->where('start_date_en', '<=', $trans_start)->where('end_date_en', '>=', $trans_start)->first();
        //if(!empty($fiscals->end_date_en)){
        $fiscal_split = $fiscal_datas->where('start_date_en', '<=', $fiscals->end_date_en)->where('end_date_en', '>=', $trans_end);

        //split again if seperate fiscal year
        if (empty($fiscal_split->count())) {
            $data[$i]['start_date'] = $trans_start;
            $data[$i]['end_date'] = $fiscals->end_date_en;
            $this->fiscal_split($data, date('Y-m-d', strtotime('+1 days', strtotime($fiscals->end_date_en))), $trans_end, $filter_end_date);
        } else {
            $data[$i]['start_date'] = $trans_start;
            if ($filter_end_date < $trans_end) {
                $data[$i]['end_date'] = $filter_end_date;
            } else {
                $data[$i]['end_date'] = $trans_end;
            }

        }
        //}
        return $data;
    }

    public function interest_calculation_filter($fiscal_year_id, $interest_start_date, $interest_end_date, $investment_subtype_id, $fiscals)
    {
        /*$deposits = Deposit::query();
        $deposits = $deposits->withoutGlobalScope('is_pending');

        if (!empty($fiscal_year_id) && empty($interest_start_date)) {
            $selectedFiscalYear = FiscalYear::find($fiscal_year_id);
            if (!empty($selectedFiscalYear)) {
                $deposits = $deposits->where(function ($query) use ($selectedFiscalYear) {
                    $query->where([['trans_date_en', '>=', $selectedFiscalYear->start_date_en], ['mature_date_en', '<=', $selectedFiscalYear->end_date_en]]);
                    $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->start_date_en], ['mature_date_en', '>=', $selectedFiscalYear->start_date_en]]);
                    $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->end_date_en], ['mature_date_en', '>=', $selectedFiscalYear->end_date_en]]);
                    $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->start_date_en], ['mature_date_en', '>=', $selectedFiscalYear->end_date_en]]);
                });
            }
        }

        if (!empty($interest_start_date)) {
            $start_date_en = $interest_start_date;
            $end_date_en = date('Y-m-d');
            if (!empty($interest_end_date)) {
                $end_date_en = $interest_end_date;
            }
            $deposits = $deposits->where(function ($query) use ($start_date_en, $end_date_en) {
                $query->where([['trans_date_en', '>=', $start_date_en], ['mature_date_en', '<=', $end_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $start_date_en], ['mature_date_en', '>=', $start_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $end_date_en], ['mature_date_en', '>=', $end_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $start_date_en], ['mature_date_en', '>=', $end_date_en]]);
            });
        }

        if ($investment_subtype_id != null) { //filter of investment sub type
            $deposits = $deposits->where('investment_subtype_id', $investment_subtype_id);
        }

        $deposits = $deposits->with('fiscalyear', 'institute', 'bank', 'deposit_type', 'branch', 'bank_branch', 'withdraw', 'actualEarning')->get();*/
        $count_start_day_int_calc = Config::get('constants.count_start_day_int_calc');
        $response = $this->getDepositRecord(null, $fiscal_year_id, $interest_start_date, $interest_end_date, [], null, null, null, null, null, null, true, $investment_subtype_id, null);
        $deposits = $response['details'];

        $i = 0;
        $details = [];
        if (empty($interest_start_date) && empty($interest_end_date) && !empty($fiscal_year_id)) {
            $selectedFiscalYear = FiscalYear::find($fiscal_year_id);
            if (!empty($selectedFiscalYear)) {
                $interest_start_date = $selectedFiscalYear->start_date_en;
                $interest_end_date = $selectedFiscalYear->end_date_en;
            }

        }
        foreach ($deposits as $deposit) {
            $ultimate_start = $deposit->trans_date_en;  //deposit transaction start before checking filter interest calculation start
            $ultimate_end = $deposit->mature_date_en; // deposit transaction end before checking filter interest calculation end


            if (!empty($ultimate_start) && !empty($ultimate_end)) {

                if (isset($interest_end_date)) {
                    if ($deposit->trans_date_en > $interest_end_date) {  //if interest calculation end date is less than deposit transaction start date then skip the deposit
                        continue;
                    }
                    if ($interest_end_date < $deposit->mature_date_en) { //if interest calucalation end date is less than the mature date then the interest is calculated only upto the interest calculation end date
                        $ultimate_end = $interest_end_date;
                    }
                }

                if (isset($interest_start_date)) {
                    if ($interest_start_date > $deposit->trans_date_en) { //if interest calculation start date is greater then the transaction date then the interest calculation is calculated only through interest calculation start date.
                        $ultimate_start = $interest_start_date;
                    }
                }


                $fiscal_split = $fiscals->where('start_date_en', '<=', $ultimate_start)->where('end_date_en', '>=', $ultimate_end); //checking if the deposit after date filter lies in different fiscal years or not
                if ($fiscal_split->count() == 0) { // if zero it lies in different fiscal years.
                    $data_array = array();
                    $arr = $this->fiscal_split($data_array, $ultimate_start, $ultimate_end, $ultimate_end); // gives array of the fiscal year splits start and end date
                    foreach ($arr as $date) {
                        $interest_start_days = $date['start_date'];
                        $interest_end_days = $date['end_date'];
                        $days = Carbon::parse($interest_start_days)->diffInDays($interest_end_days);
                        //count start day
                        if ($count_start_day_int_calc) {
                            $days = $days + 1;
                        }
                        if ($days != null) {
                            $grantotal = $deposit->deposit_amount;
                            $interest_percentage = $deposit->interest_rate;
                            $calculate_days = $days;
                            $estimated_earning = round(($interest_percentage / 100) * $grantotal * ($calculate_days / 365),
                                2);
                            $detail_fiscal = $fiscals->where('start_date_en', '<=', $interest_start_days)->where('end_date_en', '>=', $interest_end_days)->first();
                            $details[$i]['id'] = $deposit->id;
                            $details[$i]['fiscal_code'] = $detail_fiscal->code;
                            $details[$i]['trans_date_en'] = $deposit->trans_date_en;
                            $details[$i]['institution_name'] = $deposit->institute->institution_name ?? '';
                            $details[$i]['branch_name'] = $deposit->branch->branch_name ?? '';
                            $details[$i]['deposit_type'] = $deposit->deposit_type->name ?? '';
                            $details[$i]['fd_number'] = $deposit->document_no;
                            $details[$i]['days'] = $calculate_days;
                            $details[$i]['mature_date_en'] = $deposit->mature_date_en;
                            $details[$i]['deposit_amount'] = $deposit->deposit_amount;
                            $details[$i]['interest_rate'] = $deposit->interest_rate;
                            $details[$i]['estimated_earning'] = $estimated_earning;
                            $details[$i]['interest_start'] = $interest_start_days;
                            $details[$i]['interest_end'] = $interest_end_days;
                            $details[$i]['status'] = $deposit->status;
                            $details[$i]['reference_number'] = $deposit->reference_number;
                            $actual_earning_on_time_frame = $deposit->actualEarning->where('date_en', '>=', $interest_start_days)->where('date_en', '<=', $interest_end_days)->sum('amount');
                            $details[$i]['accured_interest'] = $estimated_earning - $actual_earning_on_time_frame;
                            $details[$i]['received_interest'] = $actual_earning_on_time_frame;
                            $details[$i]['has_child'] = !empty($deposit->child);
                            $details[$i]['has_withdraw'] = !empty($deposit->withdraw);
                            $details[$i]['earmarked'] = $deposit->earmarked == 1 ? "Yes" : "No";
                            $i++;
                        }
                    }
                } else { // fiscal year doesnot split

                    $interest_start_days = $deposit->trans_date_en;
                    $interest_end_days = $deposit->mature_date_en;

                    if (isset($interest_start_date)) {
                        if ($interest_start_date > $deposit->trans_date_en) { //if interest calculation start date is greater then the transaction date then the interest calculation is calculated only through interest calculation start date.
                            $interest_start_days = $interest_start_date;
                        }
                    }
                    if (isset($interest_start_date)) {
                        if ($interest_end_date < $deposit->mature_date_en) { //if interest calucalation end date is less than the mature date then the interest is calculated only upto the interest calculation end date
                            $interest_end_days = $interest_end_date;
                        }
                    }

                    $days = Carbon::parse($interest_start_days)->diffInDays($interest_end_days);
                    //count start day
                    if ($count_start_day_int_calc) {
                        $days = $days + 1;
                    }
                    if ($days != null) {

                        $grantotal = $deposit->deposit_amount;
                        $interest_percentage = $deposit->interest_rate;
                        $calculate_days = $days;
                        if ($calculate_days >= $deposit->days) {
                            $calculate_days = $deposit->days;
                        }
                        $estimated_earning = round(($interest_percentage / 100) * $grantotal * ($calculate_days / 365),
                            2);
                        $detail_fiscal = $fiscals->where('start_date_en', '<=', $interest_start_days)->where('end_date_en', '>=', $interest_end_days)->first();

                        $details[$i]['id'] = $deposit->id;
                        $details[$i]['fiscal_code'] = $detail_fiscal->code;
                        $details[$i]['trans_date_en'] = $deposit->trans_date_en;
                        $details[$i]['institution_name'] = $deposit->institute->institution_name ?? '';
                        $details[$i]['branch_name'] = $deposit->branch->branch_name ?? '';
                        $details[$i]['deposit_type'] = $deposit->deposit_type->name ?? '';
                        $details[$i]['fd_number'] = $deposit->document_no;
                        $details[$i]['days'] = $calculate_days;
                        $details[$i]['mature_date_en'] = $deposit->mature_date_en;
                        $details[$i]['deposit_amount'] = $deposit->deposit_amount;
                        $details[$i]['interest_rate'] = $deposit->interest_rate;
                        $details[$i]['estimated_earning'] = $estimated_earning;
                        $details[$i]['interest_start'] = $interest_start_days;
                        $details[$i]['interest_end'] = $interest_end_days;
                        $details[$i]['status'] = $deposit->status;
                        $details[$i]['reference_number'] = $deposit->reference_number;
                        $actual_earning_on_time_frame = $deposit->actualEarning->where('date_en', '>=', $interest_start_days)->where('date_en', '<=', $interest_end_days)->sum('amount');
                        $details[$i]['accured_interest'] = $estimated_earning - $actual_earning_on_time_frame;
                        $details[$i]['received_interest'] = $actual_earning_on_time_frame;
                        $details[$i]['has_child'] = !empty($deposit->child);
                        $details[$i]['has_withdraw'] = !empty($deposit->withdraw);
                        $details[$i]['earmarked'] = $deposit->earmarked == 1 ? "Yes" : "No";
                        $i++;
                    }
                }
            }
        }

        return $details;

    }

    public function deposit_summary_filter($fiscal_year_id, $interest_start_date, $interest_end_date, $investment_subtype_id, $fiscals)
    {
        $i = 0;
        $data = [];
        $deposit_id = InvestmentType::InvestmenttypeDeposit();
        $investment = InvestmentType::findOrFail($deposit_id);
        $investment_subtypes = $investment->investment_subtype;
        foreach ($investment_subtypes as $deposit_type) {
            $data['details'][$deposit_type->id]['id'] = $deposit_type->id;
            $data['details'][$deposit_type->id]['deposit_type'] = $deposit_type->name;

            $deposit = $this->getDepositRecord(null, $fiscal_year_id, $interest_start_date, $interest_end_date, [], null, null,
                null, null, null, null, true, $deposit_type->id, null)['deposits'];

            $closing_balance = $deposit->where('status', '!=', 4)->where('status', '!=', 5)->sum('deposit_amount') +
                $deposit->where('child', null)->where('status', 4)->sum('deposit_amount') + $deposit->where('withdraw', null)->where('status', 5)->sum('deposit_amount');

            $estimatedEarning = $deposit->where('status', '!=', 4)->where('status', '!=', 5)->sum('estimated_earning') +
                $deposit->where('child', null)->where('status', 4)->sum('estimated_earning') + $deposit->where('withdraw', null)->where('status', 5)->sum('estimated_earning');
            $data['details'][$deposit_type->id]['closing_balance'] = $closing_balance;
            $data['details'][$deposit_type->id]['estimated_earning'] = $estimatedEarning;

        }

        return $data;
    }

    public function summary_report(Request $request)
    {
        $fiscals = $this->fiscal_years;
        $data['fiscal_years'] = $fiscals;
        $input = Input::all();
        $data['show_index'] = 0;
        $deposit_id = InvestmentType::InvestmenttypeDeposit();
        $investment = InvestmentType::with('invest_inst', 'investment_subtype')->findOrFail($deposit_id);
        $data['institutes'] = $investment->invest_inst;
        $data['investment_subtypes'] = $investment->investment_subtype;

        //hide table data if no filters
        if (count($input) > 0) {
            $data['show_index'] = 1;
            $details = $this->deposit_summary_filter($request->fiscal_year_id, $request->interest_start_date_en, $request->interest_end_date_en, $request->investment_subtype_id, $fiscals);
            $data = array_merge($data, $details);
        }
        return view('report.deposit-summary.summaryreport', $data);
    }

    public function summary_report_excel(Request $request)
    {
        $fiscals = $this->fiscal_years;
        $data['fiscal_years'] = $fiscals;
        $input = Input::all();
        $details = $this->deposit_summary_filter($request->fiscal_year_id, $request->interest_start_date_en, $request->interest_end_date_en, $request->investment_subtype_id, $fiscals);
        $data = array_merge($data, $details);
        Excel::create('Deposit Summary', function ($excel) use ($data) {

            $excel->sheet('Deposit Summary', function ($sheet) use ($data) {
                $sheet->freezeFirstRow();
                $sheet->loadView('report.deposit-summary.summary-report-table', $data);
            });

        })->download('xlsx');


    }

    public function share_summary(Request $request)
    {
        ini_set('max_execution_time', 1800);
        ini_set('memory_limit', '1024M');
        $data['fiscal_years'] = $this->fiscal_years->pluck('code', 'id');
        $data['institutions'] = InvestmentInstitution::where('invest_type_id', 3)->pluck('institution_name', 'institution_code');
        $data['investment_sectors'] = InvestmentSubType::where('invest_type_id', 3)->pluck('name', 'id');
        $input = Input::all();
        $share = new Share();
        $openingBalanceClosingDate = null;
        $filerClosingDate = null;
        if (!empty($input['fiscal_year_id'])) {
            $openingBalanceClosingDate = $this->fiscal_years->where('id', $input['fiscal_year_id'])->last()->start_date_en ?? null;
            $filerClosingDate = $this->fiscal_years->where('id', $input['fiscal_year_id'])->last()->end_date_en ?? null;
            $share = $share->where('fiscal_year_id', $input['fiscal_year_id']);
        }
        if (!empty($input['start_date'])) {
            $share = $share->where('trans_date_en', '>=', $input['start_date']);
            $openingBalanceClosingDate = $input['start_date'];
        }
        $openingBalancePurchase = $openingBalanceSales = null;
        if (!empty($openingBalanceClosingDate)) {
            $openingBalancePurchase = DB::table('shares')
                ->select(DB::raw('sum(total_amount) as purchase_amount'), DB::raw('sum(purchase_kitta) as purchase_kitta'), 'institution_code')
                ->where('share_type_id', '<>', 6)
                ->where('trans_date_en', '<', $openingBalanceClosingDate)
                ->groupBy('institution_code')
                ->get();
            $openingBalanceSales = DB::table('shares')
                ->select(DB::raw('sum(total_amount) as sales_amount'), DB::raw('sum(purchase_kitta) as sales_kitta'), 'institution_code')
                ->where('share_type_id', '=', 6)
                ->where('trans_date_en', '<', $openingBalanceClosingDate)
                ->groupBy('institution_code')
                ->get();
        }
        $data['openingBalancePurchase'] = $openingBalancePurchase;
        $data['openingBalanceSales'] = $openingBalanceSales;
        if (!empty($input['end_date'])) {
            $filerClosingDate = $input['end_date'];
            $share = $share->where('trans_date_en', '<=', $input['end_date']);
        }
        if (!empty($input['invest_subtype_id'])) {
            $share = $share->where('investment_subtype_id', $input['invest_subtype_id']);
        }
        $share = $share->with('investment_sector', 'dividend')->get();
        $data['share'] = $share;


        $distinct_share_institutions = InvestmentInstitution::where('invest_type_id', 3)->whereHas('shares')->with(['invest_sector', 'latest_share_price' => function ($query) use ($filerClosingDate) {
            if (!empty($filerClosingDate)) {
                $query->where('date', '<=', $filerClosingDate);
            }
        }, 'dividends' => function ($query) use ($openingBalanceClosingDate, $filerClosingDate) {
            if (!empty($openingBalanceClosingDate)) {
                $query->where('date', '>=', $openingBalanceClosingDate);
            }
            if (!empty($filerClosingDate)) {
                $query->where('date', '<=', $filerClosingDate);
            }
        }]);
        if (!empty($input['institution_code'])) {
            $distinct_share_institutions = $distinct_share_institutions->where('institution_code', $input['institution_code']);
        }
        if (!empty($input['invest_subtype_id'])) {
            $distinct_share_institutions = $distinct_share_institutions->where('invest_subtype_id', $input['invest_subtype_id']);
        }
        $distinct_share_institutions = $distinct_share_institutions->get();

        $data['share_institutions'] = $distinct_share_institutions;
        $data['for_excel'] = false;
        return view('report.share-summary', $data);

    }

    public function share_summary_export(Request $request)
    {
        ini_set('max_execution_time', 1800);
        ini_set('memory_limit', '1024M');
        $data['fiscal_years'] = $this->fiscal_years->pluck('code', 'id');
        $data['institutions'] = InvestmentInstitution::where('invest_type_id', 3)->pluck('institution_name', 'institution_code');
        $data['investment_sectors'] = InvestmentSubType::where('invest_type_id', 3)->pluck('name', 'id');
        $input = Input::all();

        $share = new Share();
        $openingBalanceClosingDate = null;
        $filerClosingDate = null;

        if (!empty($input['fiscal_year_id'])) {
            $openingBalanceClosingDate = $this->fiscal_years->where('id', $input['fiscal_year_id'])->last()->start_date_en ?? null;
            $filerClosingDate = $this->fiscal_years->where('id', $input['fiscal_year_id'])->last()->end_date_en ?? null;
            $share = $share->where('fiscal_year_id', $input['fiscal_year_id']);
        }
        if (!empty($input['start_date'])) {
            $share = $share->where('trans_date_en', '>=', $input['start_date']);
            $openingBalanceClosingDate = $input['start_date'];
        }
        $openingBalancePurchase = $openingBalanceSales = null;
        if (!empty($openingBalanceClosingDate)) {
            $openingBalancePurchase = DB::table('shares')
                ->select(DB::raw('sum(total_amount) as purchase_amount'), DB::raw('sum(purchase_kitta) as purchase_kitta'), 'institution_code')
                ->where('share_type_id', '<>', 6)
                ->where('trans_date_en', '<', $openingBalanceClosingDate)
                ->groupBy('institution_code')
                ->get();
            $openingBalanceSales = DB::table('shares')
                ->select(DB::raw('sum(total_amount) as sales_amount'), DB::raw('sum(purchase_kitta) as sales_kitta'), 'institution_code')
                ->where('share_type_id', '=', 6)
                ->where('trans_date_en', '<', $openingBalanceClosingDate)
                ->groupBy('institution_code')
                ->get();
        }
        $data['openingBalancePurchase'] = $openingBalancePurchase;
        $data['openingBalanceSales'] = $openingBalanceSales;

        if (!empty($input['end_date'])) {
            $filerClosingDate = $input['end_date'];
            $share = $share->where('trans_date_en', '<=', $input['end_date']);
        }
        if (!empty($input['invest_subtype_id'])) {
            $share = $share->where('investment_subtype_id', $input['invest_subtype_id']);
        }
        $share = $share->with('investment_sector')->get();
        $data['share'] = $share;
        $distinct_share_institutions = InvestmentInstitution::where('invest_type_id', 3)->whereHas('shares')->with(['invest_sector', 'latest_share_price' => function ($query) use ($filerClosingDate) {
            if (!empty($filerClosingDate)) {
                $query->where('date', '<=', $filerClosingDate);
            }
        }, 'dividends' => function ($query) use ($openingBalanceClosingDate, $filerClosingDate) {
            if (!empty($openingBalanceClosingDate)) {
                $query->where('date', '>=', $openingBalanceClosingDate);
            }
            if (!empty($filerClosingDate)) {
                $query->where('date', '<=', $filerClosingDate);
            }
        }]);
        if (!empty($input['institution_code'])) {
            $distinct_share_institutions = $distinct_share_institutions->where('institution_code', $input['institution_code']);
        }
        if (!empty($input['invest_subtype_id'])) {
            $distinct_share_institutions = $distinct_share_institutions->where('invest_subtype_id', $input['invest_subtype_id']);
        }
        $distinct_share_institutions = $distinct_share_institutions->get();
        $data['share_institutions'] = $distinct_share_institutions;
        $data['for_excel'] = true;
        Excel::create('Share Summary', function ($excel) use ($data) {

            $excel->sheet('Share Summary', function ($sheet) use ($data) {
                $sheet->freezeFirstRow();
                $sheet->loadView('report.share-summary-table', $data);
            });

        })->download('xlsx');

    }

    public function sharePriceAtDate(Request $request)
    {
        $data['fiscal_years'] = $this->fiscal_years->pluck('code', 'id');
        $data['institutions'] = InvestmentInstitution::where('invest_type_id', 3)->pluck('institution_name', 'institution_code');
        $data['investment_sectors'] = InvestmentSubType::where('invest_type_id', 3)->pluck('name', 'id');

        $input = Input::all();
        $distinct_share_institutions = Share::query();
        if (!empty($input['institution_code'])) {
            $distinct_share_institutions = $distinct_share_institutions->where('institution_code', $input['institution_code']);
        }
        if (!empty($input['invest_subtype_id'])) {
            $distinct_share_institutions = $distinct_share_institutions->where('investment_subtype_id', $input['invest_subtype_id']);
        }

        $at_date = $input['at_date'] ?? date('Y-m-d');

        $distinct_share_institutions = $distinct_share_institutions->with(['instituteByCode', 'share_price_last' => function ($query) use ($at_date) {
            $query->where('date', '<=', $at_date);
        }])->select('institution_code')->distinct()->get();
        $share = new Share();
        if (!empty($input['fiscal_year_id'])) {
            $share = $share->where('fiscal_year_id', $input['fiscal_year_id']);
        }

        if (!empty($input['at_date'])) {
//            $share = $share->where('trans_date_en', '<=', $input['at_date']);
        }

        if (!empty($input['invest_subtype_id'])) {
            $share = $share->where('investment_subtype_id', $input['invest_subtype_id']);
        }
        $share = $share->with('investment_sector')->get();

        $data['share'] = $share;
        $data['share_institutions'] = $distinct_share_institutions;
        return view('report.share-at-date', $data);
    }

    public function shareHistory(Request $request)
    {
        $share_institutions = InvestmentInstitution::where('invest_type_id', 3);
        $data['select_institutions'] = $share_institutions->get();
        if (!empty($request->institution_code)) {
            $share_institutions = $share_institutions->where('institution_code', $request->institution_code);
        }
        $date = date('Y-m-d', strtotime('-1 day'));
        if (!empty($request->date)) {
            $date = $request->date;
        }
        $data['institutions'] = $share_institutions->with(['latest_share_price' => function ($q) use ($date) {
            $q->where('date', '<=', $date);
        }])->get();
        $data['i'] = 1;
        return view('report.share-price-history', $data);
    }

    public function investment_report(Request $request)
    {
        $quaters = Config::get('constants.quaters');
        $fiscal_years = FiscalYear::get();
        if (!empty($request->quarter)) {
            $report_for_quater = $quaters[$request->quarter];
        } else {
            $today_date = date('Y-m-d');
            $today_date_np = BSDateHelper::AdToBsEN('-', $today_date);
            $current_nepali_month = date('m', strtotime($today_date_np));
            foreach ($quaters as $quater) {
                if ($quater[0] <= $current_nepali_month && $quater[1] >= $current_nepali_month) {
                    $report_for_quater = $quater;
                    break;
                }
            }
        }
        if (!empty($request->fiscal_year_id)) {
            $report_for_fiscal_year = $fiscal_years->where('id', $request->fiscal_year_id)->first();
        } else {
            $report_for_fiscal_year = $fiscal_years->where('status', 1)->last();
        }

        //if the quater is fourth quater
        if ($report_for_quater[0] >= 1 && $report_for_quater[1] <= 3) {
            $date = DateTime::createFromFormat("Y-m-d", $report_for_fiscal_year->end_date);
            $year_for_report = $date->format("Y");
//            $year_for_report = date('Y', strtotime($report_for_fiscal_year->end_date));
        } else {
            $date = DateTime::createFromFormat("Y-m-d", $report_for_fiscal_year->start_date);
            $year_for_report = $date->format("Y");
//            $year_for_report = date('Y', strtotime($report_for_fiscal_year->start_date));
        }

        $last_day_of_quater = $this->getTotalNumberOfDaysByMonth($report_for_quater[1], $year_for_report);

        $quater_start_date = $year_for_report . '-' . $report_for_quater[0] . '-1';
        $quater_end_date = $year_for_report . '-' . $report_for_quater[1] . '-' . $last_day_of_quater;

        $quater_start_date_en = BSDateHelper::BsToAd('-', $quater_start_date);
        $quater_start_date_en = $report_for_fiscal_year->start_date_en;
        $quater_end_date_en = BSDateHelper::BsToAd('-', $quater_end_date);

        $data['total_technical_reserve'] = TechnicalReserve::where('approved_date_en', '<', $report_for_fiscal_year->start_date_en)->orderBy('approved_date_en', 'desc')->latest()->first()->amount ?? 0;
        $investment_sub_type = InvestmentSubType::get();
        $bond_group_on_government = $investment_sub_type->where('code', 101)->first()->id;
        $bond_group_on_others = $investment_sub_type->where('code', 112)->first()->id;
        $class_A = $investment_sub_type->where('code', 102)->first()->id;
        $infrastructure_bank = $investment_sub_type->where('code', 103)->first()->id;
        $household_and_land = $investment_sub_type->where('code', 104)->first()->id;
        $share_on_public_companies = $investment_sub_type->where('code', 105)->first()->id;
        $preferential_share = $investment_sub_type->where('code', 106)->first()->id;
        $debenture = $investment_sub_type->where('code', 107)->first()->id;
        $agri_tour_and_water = $investment_sub_type->where('code', 108)->first()->id;
        $cit_and_MF = $investment_sub_type->where('code', 109)->first()->id;
        $class_B = $investment_sub_type->where('code', 110)->first()->id;
        $class_C = $investment_sub_type->where('code', 111)->first()->id;


        $data['bonds_investment'] = Bond::where(function ($query) use ($quater_start_date_en, $quater_end_date_en) {
            $query->where([['trans_date_en', '>=', $quater_start_date_en], ['mature_date_en', '<=', $quater_end_date_en]]);
            $query->orWhere([['trans_date_en', '<=', $quater_start_date_en], ['mature_date_en', '>=', $quater_start_date_en]]);
            $query->orWhere([['trans_date_en', '<=', $quater_end_date_en], ['mature_date_en', '>=', $quater_end_date_en]]);
            $query->orWhere([['trans_date_en', '<=', $quater_start_date_en], ['mature_date_en', '>=', $quater_end_date_en]]);
        })->where('investment_subtype_id', $bond_group_on_government)->where('status', 1)->sum('totalamount');

        $bond_on_other_organization = Bond::where(function ($query) use ($quater_start_date_en, $quater_end_date_en) {
            $query->where([['trans_date_en', '>=', $quater_start_date_en], ['mature_date_en', '<=', $quater_end_date_en]]);
            $query->orWhere([['trans_date_en', '<=', $quater_start_date_en], ['mature_date_en', '>=', $quater_start_date_en]]);
            $query->orWhere([['trans_date_en', '<=', $quater_end_date_en], ['mature_date_en', '>=', $quater_end_date_en]]);
            $query->orWhere([['trans_date_en', '<=', $quater_start_date_en], ['mature_date_en', '>=', $quater_end_date_en]]);
        })->where('investment_subtype_id', $bond_group_on_others)->sum('totalamount');

        /*$deposits = Deposit::withoutGlobalScope('is_pending')->with(['child' => function ($query) use ($quater_start_date_en, $quater_end_date_en) {
            $query->withoutGlobalScope('is_pending');
            $query->where([['trans_date_en', '>=', $quater_start_date_en], ['mature_date_en', '<=', $quater_end_date_en]]);
            $query->orWhere([['trans_date_en', '<=', $quater_start_date_en], ['mature_date_en', '>=', $quater_start_date_en]]);
            $query->orWhere([['trans_date_en', '<=', $quater_end_date_en], ['mature_date_en', '>=', $quater_end_date_en]]);
            $query->orWhere([['trans_date_en', '<=', $quater_start_date_en], ['mature_date_en', '>=', $quater_end_date_en]]);
        }, 'withdraw' => function ($query) use ($quater_start_date_en, $quater_end_date_en) {
            $query->where('withdrawdate_en', '>=', $quater_start_date_en);
            $query->where('withdrawdate_en', '<=', $quater_end_date_en);
        }])->where(function ($query) use ($quater_start_date_en, $quater_end_date_en) {
            $query->where([['trans_date_en', '>=', $quater_start_date_en], ['mature_date_en', '<=', $quater_end_date_en]]);
            $query->orWhere([['trans_date_en', '<=', $quater_start_date_en], ['mature_date_en', '>=', $quater_start_date_en]]);
            $query->orWhere([['trans_date_en', '<=', $quater_end_date_en], ['mature_date_en', '>=', $quater_end_date_en]]);
            $query->orWhere([['trans_date_en', '<=', $quater_start_date_en], ['mature_date_en', '>=', $quater_end_date_en]]);
        })->get();*/

        $classADeposit = $this->getDepositRecord(null, null, $quater_start_date_en, $quater_end_date_en, [], null, null,
            null, null, null, null, true, $class_A, null)['deposits'];

        $classBDeposit = $this->getDepositRecord(null, null, $quater_start_date_en, $quater_end_date_en, [], null, null,
            null, null, null, null, true, $class_B, null)['deposits'];

        $classCDeposit = $this->getDepositRecord(null, null, $quater_start_date_en, $quater_end_date_en, [], null, null,
            null, null, null, null, true, $class_C, null)['deposits'];

        $classInfraDeposit = $this->getDepositRecord(null, null, $quater_start_date_en, $quater_end_date_en, [], null, null,
            null, null, null, null, true, $infrastructure_bank, null)['deposits'];

        $data['class_A_investment'] = $classADeposit->where('status', '!=', 4)->where('status', '!=', 5)->sum('deposit_amount') +
            $classADeposit->where('child', null)->where('status', 4)->sum('deposit_amount') + $classADeposit->where('withdraw', null)->where('status', 5)->sum('deposit_amount');

        $data['class_B_investment'] = $classBDeposit->where('status', '!=', 4)->where('status', '!=', 5)->sum('deposit_amount') +
            $classBDeposit->where('child', null)->where('status', 4)->sum('deposit_amount') + $classBDeposit->where('withdraw', null)->where('status', 5)->sum('deposit_amount');

        $data['infrastructure_bank_investment'] = $classInfraDeposit->where('status', '!=', 4)->where('status', '!=', 5)->sum('deposit_amount') +
            $classInfraDeposit->where('child', null)->where('status', 4)->sum('deposit_amount') + $classInfraDeposit->where('withdraw', null)->where('status', 5)->sum('deposit_amount');

        $data['class_C_investment'] = $classCDeposit->where('status', '!=', 4)->where('status', '!=', 5)->sum('deposit_amount') +
            $classCDeposit->where('child', null)->where('status', 4)->sum('deposit_amount') + $classCDeposit->where('withdraw', null)->where('status', 5)->sum('deposit_amount');


        /* $data['class_A_investment'] = $deposits->where('status', '!=', 4)->where('status', '!=', 5)->where('investment_subtype_id', $class_A)->sum('deposit_amount') +
             $deposits->where('child', null)->where('status', 4)->where('investment_subtype_id', $class_A)->sum('deposit_amount') + $deposits->where('withdraw', null)->where('status', 5)->where('investment_subtype_id', $class_A)->sum('deposit_amount');

         $data['class_B_investment'] = $deposits->where('status', '!=', 4)->where('status', '!=', 5)->where('investment_subtype_id', $class_B)->sum('deposit_amount') +
             $deposits->where('child', null)->where('status', 4)->where('investment_subtype_id', $class_B)->sum('deposit_amount') + $deposits->where('withdraw', null)->where('status', 5)->where('investment_subtype_id', $class_B)->sum('deposit_amount');

         $data['infrastructure_bank_investment'] = $deposits->where('status', '!=', 4)->where('status', '!=', 5)->where('investment_subtype_id', $infrastructure_bank)->sum('deposit_amount') +
             $deposits->where('child', null)->where('status', 4)->where('investment_subtype_id', $infrastructure_bank)->sum('deposit_amount') + $deposits->where('withdraw', null)->where('status', 5)->where('investment_subtype_id', $infrastructure_bank)->sum('deposit_amount');

         $data['class_C_investment'] = $deposits->where('status', '!=', 4)->where('status', '!=', 5)->where('investment_subtype_id', $class_C)->sum('deposit_amount') +
             $deposits->where('child', null)->where('status', 4)->where('investment_subtype_id', $class_C)->sum('deposit_amount') + $deposits->where('withdraw', null)->where('status', 5)->where('investment_subtype_id', $class_C)->sum('deposit_amount');
 */
        $data['household_and_land_investment'] = 0;

        $data['investment_on_share'] = Share::whereHas('instituteByCode', function ($query) {
                $query->where('is_listed', 1);
            })->where('trans_date_en', '<=', $quater_end_date_en)->where('investment_subtype_id', $share_on_public_companies)->where('share_type_id', '<>', 6)->sum('total_amount') - Share::where('trans_date_en', '<=', $quater_end_date_en)->where('share_type_id', 6)->where('investment_subtype_id', $share_on_public_companies)->sum('total_amount');
        $data['investment_on_preferential_share'] = $bond_on_other_organization + Share::where('trans_date_en', '<=', $quater_end_date_en)->where('investment_subtype_id', $preferential_share)->where('share_type_id', '<>', 6)->sum('total_amount') - Share::where('trans_date_en', '<=', $quater_end_date_en)->where('share_type_id', 6)->where('investment_subtype_id', $preferential_share)->sum('total_amount');
        $data['investment_on_debenture'] = Share::where('trans_date_en', '<=', $quater_end_date_en)->where('investment_subtype_id', $debenture)->where('share_type_id', '<>', 6)->sum('total_amount') - Share::where('trans_date_en', '<=', $quater_end_date_en)->where('share_type_id', 6)->where('investment_subtype_id', $debenture)->sum('total_amount');
        $data['investment_on_agri_tour_and_water'] = Share::where('trans_date_en', '<=', $quater_end_date_en)->where('investment_subtype_id', $agri_tour_and_water)->where('share_type_id', '<>', 6)->sum('total_amount') - Share::where('trans_date_en', '<=', $quater_end_date_en)->where('share_type_id', 6)->where('investment_subtype_id', $agri_tour_and_water)->sum('total_amount');
        $data['investment_on_cit_and_MF'] = Share::where('trans_date_en', '<=', $quater_end_date_en)->where('investment_subtype_id', $cit_and_MF)->where('share_type_id', '<>', 6)->sum('total_amount') - Share::where('trans_date_en', '<=', $quater_end_date_en)->where('share_type_id', 6)->where('investment_subtype_id', $cit_and_MF)->sum('total_amount');
        $data['investment_on_non_listed_companies'] = Share::whereHas('instituteByCode', function ($query) {
                $query->where('is_listed', 0);
            })->where('trans_date_en', '<=', $quater_end_date_en)->where('share_type_id', '<>', 6)->sum('total_amount') - Share::whereHas('instituteByCode', function ($query) {
                $query->where('is_listed', 0);
            })->where('trans_date_en', '<=', $quater_end_date_en)->where('share_type_id', 6)->sum('total_amount');

        $data['total'] = $data['bonds_investment'] + $data['class_A_investment'] + $data['infrastructure_bank_investment'] + $data['household_and_land_investment'] + $data['class_B_investment'] + $data['class_C_investment'] + $data['investment_on_share'] + $data['investment_on_preferential_share']
            + $data['investment_on_debenture'] + $data['investment_on_agri_tour_and_water'] + $data['investment_on_cit_and_MF'] + $data['investment_on_non_listed_companies'];
        $non_listed_company_details = Share::whereHas('instituteByCode', function ($query) {
            $query->where('is_listed', 0);
        })->with('instituteByCode')->where('trans_date_en', '<=', $quater_end_date_en)->get()->groupBy('instituteByCode.institution_name');
        $counter = 0;
        $data['investment_on_non_listed_companies_details'] = [];
        foreach ($non_listed_company_details as $institution_name => $non_listed_company_detail) {
            $data['investment_on_non_listed_companies_details'][$counter]['institution_name'] = $institution_name;
            $data['investment_on_non_listed_companies_details'][$counter]['amount'] = $non_listed_company_detail->where('share_type_id', '<>', 6)->sum('total_amount') - $non_listed_company_detail->where('share_type_id', '=', 6)->sum('total_amount');
            $counter++;
        }
        $data['fiscal_years'] = $fiscal_years;
        $data['quarters'] = [
            'first' => 'Shrawan - Asoj',
            'second' => 'Kartik - Poush',
            'third' => 'Magh - Chaitra',
            'fourth' => 'Baishak - Asar',
        ];
        $data['quarter'] = (array_search($report_for_quater, $quaters));
        $data['organization'] = UserOrganization::first();
        return view('report.investment-report', $data);
    }

    public function institutionDepositPercentage(Request $request)
    {
        $quaters = Config::get('constants.quaters');
        $fiscal_years = FiscalYear::get();

        if (!empty($request->quarter) && empty($request->upto_date)) {
            $report_for_quater = $quaters[$request->quarter];
        } else {
            $today_date = $request->upto_date ?? date('Y-m-d');
            $today_date_np = BSDateHelper::AdToBsEN('-', $today_date);
            $current_nepali_month = date('m', strtotime($today_date_np));
            foreach ($quaters as $quater) {
                if ($quater[0] <= $current_nepali_month && $quater[1] >= $current_nepali_month) {
                    $report_for_quater = $quater;
                    break;
                }
            }
        }

        if (!empty($request->upto_date)) {
            $fiscal_year = $fiscal_years->where('start_date_en', '<=', $request->upto_date)->where('end_date_en', '>=', $request->upto_date)->first();
            $quater_start_date_en = $fiscal_year->start_date_en;
            $quater_end_date_en = $request->upto_date;
            $report_for_fiscal_year = $fiscal_year;
        } else {

            if (!empty($request->fiscal_year_id)) {
                $report_for_fiscal_year = $fiscal_years->where('id', $request->fiscal_year_id)->first();
            } else {
                $report_for_fiscal_year = $fiscal_years->where('status', 1)->last();
            }

            //if the quater is fourth quater
            if ($report_for_quater[0] >= 1 && $report_for_quater[1] <= 3) {
                $date = DateTime::createFromFormat("Y-m-d", $report_for_fiscal_year->end_date);
                $year_for_report = $date->format("Y");
            } else {
                $date = DateTime::createFromFormat("Y-m-d", $report_for_fiscal_year->start_date);
                $year_for_report = $date->format("Y");
            }

            $last_day_of_quater = $this->getTotalNumberOfDaysByMonth($report_for_quater[1], $year_for_report);

            $quater_start_date = $year_for_report . '-' . $report_for_quater[0] . '-1';
            $quater_end_date = $year_for_report . '-' . $report_for_quater[1] . '-' . $last_day_of_quater;

            $quater_start_date_en = BSDateHelper::BsToAd('-', $quater_start_date);
            //quarter start set fiscal year start date
            $quater_start_date_en = $report_for_fiscal_year->start_date_en;
            $quater_end_date_en = BSDateHelper::BsToAd('-', $quater_end_date);
        }
        $technical_reserve = TechnicalReserve::where('approved_date_en', '<', $quater_end_date_en)->orderBy('approved_date_en', 'desc')->latest()->first()->amount ?? 0;
        $investment_sectors = InvestmentSubType::where('invest_type_id', 2)->get();
        $investment_sector_records = [];
        foreach ($investment_sectors as $investment_sector) {
            $investment_sector_records[$investment_sector->name] = [];
            $deposits = $this->getDepositRecord(null, $report_for_fiscal_year->id, $quater_start_date_en, $quater_end_date_en, [],
                null, null, null, null, null, null, true,
                $investment_sector->id, null)['deposits'];


            // to check which deposits were active at that time period
            $deposits = $deposits->filter(function ($deposit) {
                if ($deposit->status == 1 || $deposit->status == 2 || $deposit->status == 3 || ($deposit->status == 4 && $deposit->child == null) || ($deposit->status == 5 && $deposit->withdraw == null)) {
                    return true;
                } else {
                    return false;
                }
            });
            $institution_deposits = $deposits->groupBy('institute.institution_name');
            foreach ($institution_deposits as $institution_name => $institution_deposit) {

                if ($institution_deposit->count() > 0) {
                    if (!empty($institution_deposit->first()->bank_merger_id)) {
                        if ($institution_deposit->first()->bankMerger->merger_date <= $quater_end_date_en) {
                            $institution_name = $institution_deposit->first()->bankMerger->bank_name_after_merger;
                        }
                    }
                }
                $institution_deposit_amount = 0;
                if (isset($investment_sector_records[$investment_sector->name][$institution_name])) {
                    $institution_deposit_amount = $investment_sector_records[$investment_sector->name][$institution_name];
                }
                $investment_sector_records[$investment_sector->name][$institution_name] = $institution_deposit_amount + $institution_deposit->sum('deposit_amount');
            }
            arsort($investment_sector_records[$investment_sector->name]);
        }

        $data['investment_sector_records'] = $investment_sector_records;
        $data['technical_reserve'] = $technical_reserve;

        $data['fiscal_years'] = $fiscal_years;
        $data['quarters'] = [
            'first' => 'Shrawan - Asoj',
            'second' => 'Kartik - Poush',
            'third' => 'Magh - Chaitra',
            'fourth' => 'Baishak - Asar',
        ];
        $data['i'] = 1;
        $data['quarter'] = (array_search($report_for_quater, $quaters));
        return view('report.institution-deposit-percentage', $data);
    }

    public function investmentSectorPercentage(Request $request)
    {
        $quaters = Config::get('constants.quaters');
        $fiscal_years = FiscalYear::get();
        if (!empty($request->quarter)) {
            $report_for_quater = $quaters[$request->quarter];
        } else {
            $today_date = date('Y-m-d');
            $today_date_np = BSDateHelper::AdToBsEN('-', $today_date);
            $current_nepali_month = date('m', strtotime($today_date_np));
            foreach ($quaters as $quater) {
                if ($quater[0] <= $current_nepali_month && $quater[1] >= $current_nepali_month) {
                    $report_for_quater = $quater;
                    break;
                }
            }
        }
        if (!empty($request->fiscal_year_id)) {
            $report_for_fiscal_year = $fiscal_years->where('id', $request->fiscal_year_id)->first();
        } else {
            $report_for_fiscal_year = $fiscal_years->where('status', 1)->last();
        }

        //if the quater is fourth quater
        if ($report_for_quater[0] >= 1 && $report_for_quater[1] <= 3) {
            $date = DateTime::createFromFormat("Y-m-d", $report_for_fiscal_year->end_date);
            $year_for_report = $date->format("Y");
//            $year_for_report = date('Y', strtotime($report_for_fiscal_year->end_date));
        } else {
            $date = DateTime::createFromFormat("Y-m-d", $report_for_fiscal_year->start_date);
            $year_for_report = $date->format("Y");
//            $year_for_report = date('Y', strtotime($report_for_fiscal_year->start_date));
        }

        $last_day_of_quater = $this->getTotalNumberOfDaysByMonth($report_for_quater[1], $year_for_report);

        $quater_start_date = $year_for_report . '-' . $report_for_quater[0] . '-1';
        $quater_end_date = $year_for_report . '-' . $report_for_quater[1] . '-' . $last_day_of_quater;

        $quater_start_date_en = BSDateHelper::BsToAd('-', $quater_start_date);
        $quater_end_date_en = BSDateHelper::BsToAd('-', $quater_end_date);

        $quater_start_date_en = $report_for_fiscal_year->start_date_en;

        $technical_reserve = TechnicalReserve::where('approved_date_en', '<', $quater_end_date_en)->orderBy('approved_date_en', 'desc')->latest()->first()->amount ?? 0;

        $investment_sub_type = InvestmentSubType::get();
        $bond_group_on_government = $investment_sub_type->where('code', 101)->first();
        $class_A = $investment_sub_type->where('code', 102)->first();
        $infrastructure_bank = $investment_sub_type->where('code', 103)->first();
        $household_and_land = $investment_sub_type->where('code', 104)->first();
        $share_on_public_companies = $investment_sub_type->where('code', 105)->first();
        $preferential_share = $investment_sub_type->where('code', 106)->first();
        $debenture = $investment_sub_type->where('code', 107)->first();
        $agri_tour_and_water = $investment_sub_type->where('code', 108)->first();
        $cit_and_MF = $investment_sub_type->where('code', 109)->first();
        $class_B = $investment_sub_type->where('code', 110)->first();
        $class_C = $investment_sub_type->where('code', 111)->first();
        $bond_group_on_private = $investment_sub_type->where('code', 112)->first();

        if (!empty($technical_reserve)) {
            $data['investment_sector']['Government Bond']['present_percentage'] =
                round((Bond::where('status', 1)->where('trans_date_en', '<=', $quater_end_date_en)->where('mature_date_en', '>=', $quater_start_date_en)->where('investment_subtype_id', $bond_group_on_government->id)->sum('totalamount') / $technical_reserve) * 100, 3);
            $data['investment_sector']['Government Bond']['to_be_percentage'] = $bond_group_on_government->percentage;
            $data['investment_sector']['Government Bond']['status'] =
                $data['investment_sector']['Government Bond']['present_percentage'] >
                $data['investment_sector']['Government Bond']['to_be_percentage'];

            $data['investment_sector']['Private Bond']['present_percentage'] =
                round((Bond::where('status', 1)->where('trans_date_en', '<=', $quater_end_date_en)->where('mature_date_en', '>=', $quater_start_date_en)->where('investment_subtype_id', $bond_group_on_private->id)->sum('totalamount') / $technical_reserve) * 100, 3);
            $data['investment_sector']['Private Bond']['to_be_percentage'] = $bond_group_on_private->percentage;
            $data['investment_sector']['Private Bond']['status'] =
                $data['investment_sector']['Private Bond']['present_percentage'] <
                $data['investment_sector']['Private Bond']['to_be_percentage'];

            $class_A_deposits = $this->getDepositRecord(null, $report_for_fiscal_year->id, $quater_start_date_en, $quater_end_date_en, [],
                null, null, null, null, null, null, true,
                $class_A->id, null)['deposits'];
            // to check which deposits were active at that time period
            $class_A_deposits = $class_A_deposits->filter(function ($deposit) {
                if ($deposit->status == 1 || $deposit->status == 2 || $deposit->status == 3 || ($deposit->status == 4 && $deposit->child == null) || ($deposit->status == 5 && $deposit->withdraw == null)) {
                    return true;
                } else {
                    return false;
                }
            });
            $class_A_Amount = $class_A_deposits->sum('deposit_amount');

            $class_infrastructure_bank_deposits = $this->getDepositRecord(null, $report_for_fiscal_year->id, $quater_start_date_en, $quater_end_date_en, [],
                null, null, null, null, null, null, true,
                $infrastructure_bank->id, null)['deposits'];


            // to check which deposits were active at that time period
            $class_infrastructure_bank_deposits = $class_infrastructure_bank_deposits->filter(function ($deposit) {
                if ($deposit->status == 1 || $deposit->status == 2 || $deposit->status == 3 || ($deposit->status == 4 && $deposit->child == null) || ($deposit->status == 5 && $deposit->withdraw == null)) {
                    return true;
                } else {
                    return false;
                }
            });
            $class_Infra_Amount = $class_infrastructure_bank_deposits->sum('deposit_amount');


            $data['investment_sector']['Class A and Infrastructure Bank']['present_percentage'] =
                round((($class_A_Amount + $class_Infra_Amount) / $technical_reserve) * 100, 3);
            $data['investment_sector']['Class A and Infrastructure Bank']['to_be_percentage'] = 40;
            $data['investment_sector']['Class A and Infrastructure Bank']['status'] =
                $data['investment_sector']['Class A and Infrastructure Bank']['present_percentage'] >
                $data['investment_sector']['Class A and Infrastructure Bank']['to_be_percentage'];

            $data['investment_sector']['Household and Land']['present_percentage'] = 0;
            $data['investment_sector']['Household and Land']['to_be_percentage'] = $household_and_land->percentage;
            $data['investment_sector']['Household and Land']['status'] =
                $data['investment_sector']['Household and Land']['present_percentage'] <
                $data['investment_sector']['Household and Land']['to_be_percentage'];


            $class_B_deposits = $this->getDepositRecord(null, $report_for_fiscal_year->id, $quater_start_date_en, $quater_end_date_en, [],
                null, null, null, null, null, null, true,
                $class_B->id, null)['deposits'];


            // to check which deposits were active at that time period
            $class_B_deposits = $class_B_deposits->filter(function ($deposit) {
                if ($deposit->status == 1 || $deposit->status == 2 || $deposit->status == 3 || ($deposit->status == 4 && $deposit->child == null) || ($deposit->status == 5 && $deposit->withdraw == null)) {
                    return true;
                } else {
                    return false;
                }
            });

            $data['investment_sector']['Class B']['present_percentage'] = round(($class_B_deposits->sum('deposit_amount') / $technical_reserve) * 100, 3);
            $data['investment_sector']['Class B']['to_be_percentage'] = $class_B->percentage;
            $data['investment_sector']['Class B']['status'] =
                $data['investment_sector']['Class B']['present_percentage'] <
                $data['investment_sector']['Class B']['to_be_percentage'];


            $class_C_deposits = $this->getDepositRecord(null, $report_for_fiscal_year->id, $quater_start_date_en, $quater_end_date_en, [],
                null, null, null, null, null, null, true,
                $class_C->id, null)['deposits'];


            // to check which deposits were active at that time period
            $class_C_deposits = $class_C_deposits->filter(function ($deposit) {
                if ($deposit->status == 1 || $deposit->status == 2 || $deposit->status == 3 || ($deposit->status == 4 && $deposit->child == null) || ($deposit->status == 5 && $deposit->withdraw == null)) {
                    return true;
                } else {
                    return false;
                }
            });

            $data['investment_sector']['Class C']['present_percentage'] = round(($class_C_deposits->sum('deposit_amount') / $technical_reserve) * 100, 3);
            $data['investment_sector']['Class C']['to_be_percentage'] = $class_C->percentage;
            $data['investment_sector']['Class C']['status'] =
                $data['investment_sector']['Class C']['present_percentage'] <
                $data['investment_sector']['Class C']['to_be_percentage'];


            $data['investment_sector']['Investment on Share']['present_percentage'] = round((Share::where('trans_date_en', '<=', $quater_end_date_en)->where('investment_subtype_id', $share_on_public_companies->id)->sum('total_amount') / $technical_reserve) * 100, 3);
            $data['investment_sector']['Investment on Share']['to_be_percentage'] = $share_on_public_companies->percentage;
            $data['investment_sector']['Investment on Share']['status'] =
                $data['investment_sector']['Investment on Share']['present_percentage'] <
                $data['investment_sector']['Investment on Share']['to_be_percentage'];


            $data['investment_sector']['Investment on Preferential Share']['present_percentage'] = round((Share::where('trans_date_en', '<=', $quater_end_date_en)->where('investment_subtype_id', $preferential_share->id)->sum('total_amount') / $technical_reserve) * 100, 3);
            $data['investment_sector']['Investment on Preferential Share']['to_be_percentage'] = $preferential_share->percentage;
            $data['investment_sector']['Investment on Preferential Share']['status'] =
                $data['investment_sector']['Investment on Preferential Share']['present_percentage'] <
                $data['investment_sector']['Investment on Preferential Share']['to_be_percentage'];


            $data['investment_sector']['Debenture']['present_percentage'] = round((Share::where('trans_date_en', '<=', $quater_end_date_en)->where('investment_subtype_id', $debenture->id)->sum('total_amount') / $technical_reserve) * 100, 3);
            $data['investment_sector']['Debenture']['to_be_percentage'] = $debenture->percentage;
            $data['investment_sector']['Debenture']['status'] =
                $data['investment_sector']['Debenture']['present_percentage'] <
                $data['investment_sector']['Debenture']['to_be_percentage'];


            $data['investment_sector']['Agri. Tourism & Water']['present_percentage'] = round((Share::where('trans_date_en', '<=', $quater_end_date_en)->where('investment_subtype_id', $agri_tour_and_water->id)->sum('total_amount') / $technical_reserve) * 100, 3);
            $data['investment_sector']['Agri. Tourism & Water']['to_be_percentage'] = $agri_tour_and_water->percentage;
            $data['investment_sector']['Agri. Tourism & Water']['status'] =
                $data['investment_sector']['Agri. Tourism & Water']['present_percentage'] <
                $data['investment_sector']['Agri. Tourism & Water']['to_be_percentage'];

            $data['investment_sector']['Citizen Investment Trust and Mutual Funds']['present_percentage'] = round((Share::where('trans_date_en', '<=', $quater_end_date_en)->where('investment_subtype_id', $cit_and_MF->id)->sum('total_amount') / $technical_reserve) * 100, 3);
            $data['investment_sector']['Citizen Investment Trust and Mutual Funds']['to_be_percentage'] = $cit_and_MF->percentage;
            $data['investment_sector']['Citizen Investment Trust and Mutual Funds']['status'] =
                $data['investment_sector']['Citizen Investment Trust and Mutual Funds']['present_percentage'] <
                $data['investment_sector']['Citizen Investment Trust and Mutual Funds']['to_be_percentage'];
            /*$data['total'] = $data['bonds_investment'] + $data['class_A_investment'] + $data['infrastructure_bank_investment'] + $data['household_and_land_investment'] + $data['class_B_investment'] + $data['class_C_investment'] + $data['investment_on_share'] + $data['investment_on_preferential_share']
                + $data['investment_on_debenture'] + $data['investment_on_agri_tour_and_water'] + $data['investment_on_cit_and_MF'];*/
        }

        $data['fiscal_years'] = $fiscal_years;
        $data['quarters'] = [
            'first' => 'Shrawan - Asoj',
            'second' => 'Kartik - Poush',
            'third' => 'Magh - Chaitra',
            'fourth' => 'Baishak - Asar',
        ];
        $data['quarter'] = (array_search($report_for_quater, $quaters));
        $data['organization'] = UserOrganization::first();

        return view('report.investment-sector-percentage', $data);
    }

    public function agriTourWaterReport(Request $request)
    {
        $quaters = Config::get('constants.quaters');
        $fiscal_years = FiscalYear::get();
        if (!empty($request->quarter)) {
            $report_for_quater = $quaters[$request->quarter];
        } else {
            $today_date = date('Y-m-d');
            $today_date_np = BSDateHelper::AdToBsEN('-', $today_date);
            $current_nepali_month = date('m', strtotime($today_date_np));
            foreach ($quaters as $quater) {
                if ($quater[0] <= $current_nepali_month && $quater[1] >= $current_nepali_month) {
                    $report_for_quater = $quater;
                    break;
                }
            }
        }
        if (!empty($request->fiscal_year_id)) {
            $report_for_fiscal_year = $fiscal_years->where('id', $request->fiscal_year_id)->first();
        } else {
            $report_for_fiscal_year = $fiscal_years->where('status', 1)->last();
        }

        //if the quater is fourth quater
        if ($report_for_quater[0] >= 1 && $report_for_quater[1] <= 3) {
            $date = DateTime::createFromFormat("Y-m-d", $report_for_fiscal_year->end_date);
            $year_for_report = $date->format("Y");
//            $year_for_report = date('Y', strtotime($report_for_fiscal_year->end_date));
        } else {
            $date = DateTime::createFromFormat("Y-m-d", $report_for_fiscal_year->start_date);
            $year_for_report = $date->format("Y");
//            $year_for_report = date('Y', strtotime($report_for_fiscal_year->start_date));
        }

        $last_day_of_quater = $this->getTotalNumberOfDaysByMonth($report_for_quater[1], $year_for_report);

        $quater_start_date = $year_for_report . '-' . $report_for_quater[0] . '-1';
        $quater_end_date = $year_for_report . '-' . $report_for_quater[1] . '-' . $last_day_of_quater;

        $quater_start_date_en = BSDateHelper::BsToAd('-', $quater_start_date);
        $quater_end_date_en = BSDateHelper::BsToAd('-', $quater_end_date);

        $data['investment_areas']['Agriculture']['initial_loan_amount'] = AgriTourWaterInvestment::where('investment_area', 1)->where('date_en', '<', $quater_start_date_en)->where('type', 2)->sum('amount') - AgriTourWaterInvestment::where('investment_area', 1)->where('date_en', '<', $quater_start_date_en)->where('type', 4)->sum('amount');
        $data['investment_areas']['Tourism']['initial_loan_amount'] = AgriTourWaterInvestment::where('investment_area', 2)->where('date_en', '<', $quater_start_date_en)->where('type', 2)->sum('amount') - AgriTourWaterInvestment::where('investment_area', 2)->where('date_en', '<', $quater_start_date_en)->where('type', 4)->sum('amount');
        $data['investment_areas']['Water Resources']['initial_loan_amount'] = AgriTourWaterInvestment::where('investment_area', 3)->where('date_en', '<', $quater_start_date_en)->where('type', 2)->sum('amount') - AgriTourWaterInvestment::where('investment_area', 3)->where('date_en', '<', $quater_start_date_en)->where('type', 4)->sum('amount');
        $data['investment_areas']['Others']['initial_loan_amount'] = AgriTourWaterInvestment::where('investment_area', 4)->where('date_en', '<', $quater_start_date_en)->where('type', 2)->sum('amount') - AgriTourWaterInvestment::where('investment_area', 4)->where('date_en', '<', $quater_start_date_en)->where('type', 4)->sum('amount');

        $data['investment_areas']['Agriculture']['initial_cash_amount'] = AgriTourWaterInvestment::where('investment_area', 1)->where('date_en', '<', $quater_start_date_en)->where('type', 1)->sum('amount') - AgriTourWaterInvestment::where('investment_area', 1)->where('date_en', '<', $quater_start_date_en)->where('type', 3)->sum('amount');
        $data['investment_areas']['Tourism']['initial_cash_amount'] = AgriTourWaterInvestment::where('investment_area', 2)->where('date_en', '<', $quater_start_date_en)->where('type', 1)->sum('amount') - AgriTourWaterInvestment::where('investment_area', 2)->where('date_en', '<', $quater_start_date_en)->where('type', 3)->sum('amount');
        $data['investment_areas']['Water Resources']['initial_cash_amount'] = AgriTourWaterInvestment::where('investment_area', 3)->where('date_en', '<', $quater_start_date_en)->where('type', 1)->sum('amount') - AgriTourWaterInvestment::where('investment_area', 3)->where('date_en', '<', $quater_start_date_en)->where('type', 3)->sum('amount');
        $data['investment_areas']['Others']['initial_cash_amount'] = AgriTourWaterInvestment::where('investment_area', 4)->where('date_en', '<', $quater_start_date_en)->where('type', 1)->sum('amount') - AgriTourWaterInvestment::where('investment_area', 4)->where('date_en', '<', $quater_start_date_en)->where('type', 3)->sum('amount');

        $data['investment_areas']['Agriculture']['present_loan_amount'] = AgriTourWaterInvestment::where('investment_area', 1)->where('date_en', '>=', $quater_start_date_en)->where('date_en', '<=', $quater_end_date_en)->where('type', 2)->sum('amount') - AgriTourWaterInvestment::where('investment_area', 1)->where('date_en', '>=', $quater_start_date_en)->where('date_en', '<=', $quater_end_date_en)->where('type', 4)->sum('amount');
        $data['investment_areas']['Tourism']['present_loan_amount'] = AgriTourWaterInvestment::where('investment_area', 2)->where('date_en', '>=', $quater_start_date_en)->where('date_en', '<=', $quater_end_date_en)->where('type', 2)->sum('amount') - AgriTourWaterInvestment::where('investment_area', 2)->where('date_en', '>=', $quater_start_date_en)->where('date_en', '<=', $quater_end_date_en)->where('type', 4)->sum('amount');
        $data['investment_areas']['Water Resources']['present_loan_amount'] = AgriTourWaterInvestment::where('investment_area', 3)->where('date_en', '>=', $quater_start_date_en)->where('date_en', '<=', $quater_end_date_en)->where('type', 2)->sum('amount') - AgriTourWaterInvestment::where('investment_area', 3)->where('date_en', '>=', $quater_start_date_en)->where('date_en', '<=', $quater_end_date_en)->where('type', 4)->sum('amount');
        $data['investment_areas']['Others']['present_loan_amount'] = AgriTourWaterInvestment::where('investment_area', 4)->where('date_en', '>=', $quater_start_date_en)->where('date_en', '<=', $quater_end_date_en)->where('type', 2)->sum('amount') - AgriTourWaterInvestment::where('investment_area', 4)->where('date_en', '>=', $quater_start_date_en)->where('date_en', '<=', $quater_end_date_en)->where('type', 4)->sum('amount');

        $data['investment_areas']['Agriculture']['present_cash_amount'] = AgriTourWaterInvestment::where('investment_area', 1)->where('date_en', '>=', $quater_start_date_en)->where('date_en', '<=', $quater_end_date_en)->where('type', 1)->sum('amount') - AgriTourWaterInvestment::where('investment_area', 1)->where('date_en', '>=', $quater_start_date_en)->where('date_en', '<=', $quater_end_date_en)->where('type', 3)->sum('amount');
        $data['investment_areas']['Tourism']['present_cash_amount'] = AgriTourWaterInvestment::where('investment_area', 2)->where('date_en', '>=', $quater_start_date_en)->where('date_en', '<=', $quater_end_date_en)->where('type', 1)->sum('amount') - AgriTourWaterInvestment::where('investment_area', 2)->where('date_en', '>=', $quater_start_date_en)->where('date_en', '<=', $quater_end_date_en)->where('type', 3)->sum('amount');
        $data['investment_areas']['Water Resources']['present_cash_amount'] = AgriTourWaterInvestment::where('investment_area', 3)->where('date_en', '>=', $quater_start_date_en)->where('date_en', '<=', $quater_end_date_en)->where('type', 1)->sum('amount') - AgriTourWaterInvestment::where('investment_area', 3)->where('date_en', '>=', $quater_start_date_en)->where('date_en', '<=', $quater_end_date_en)->where('type', 3)->sum('amount');
        $data['investment_areas']['Others']['present_cash_amount'] = AgriTourWaterInvestment::where('investment_area', 4)->where('date_en', '>=', $quater_start_date_en)->where('date_en', '<=', $quater_end_date_en)->where('type', 1)->sum('amount') - AgriTourWaterInvestment::where('investment_area', 4)->where('date_en', '>=', $quater_start_date_en)->where('date_en', '<=', $quater_end_date_en)->where('type', 3)->sum('amount');
        $data['i'] = 1;
        $data['fiscal_years'] = $fiscal_years;
        $data['quarters'] = [
            'first' => 'Shrawan - Asoj',
            'second' => 'Kartik - Poush',
            'third' => 'Magh - Chaitra',
            'fourth' => 'Baishak - Asar',
        ];
        $data['quarter'] = (array_search($report_for_quater, $quaters));
        $data['organization'] = UserOrganization::first();

        return view('report.agri-tour-water-report', $data);

    }

    public function landBuildingReport(Request $request)
    {
        $quaters = Config::get('constants.quaters');
        $fiscal_years = FiscalYear::get();
        if (!empty($request->quarter)) {
            $report_for_quater = $quaters[$request->quarter];
        } else {
            $today_date = date('Y-m-d');
            $today_date_np = BSDateHelper::AdToBsEN('-', $today_date);
            $current_nepali_month = date('m', strtotime($today_date_np));
            foreach ($quaters as $quater) {
                if ($quater[0] <= $current_nepali_month && $quater[1] >= $current_nepali_month) {
                    $report_for_quater = $quater;
                    break;
                }
            }
        }
        if (!empty($request->fiscal_year_id)) {
            $report_for_fiscal_year = $fiscal_years->where('id', $request->fiscal_year_id)->first();
        } else {
            $report_for_fiscal_year = $fiscal_years->where('status', 1)->last();
        }

        //if the quater is fourth quater
        if ($report_for_quater[0] >= 1 && $report_for_quater[1] <= 3) {
            $date = DateTime::createFromFormat("Y-m-d", $report_for_fiscal_year->end_date);
            $year_for_report = $date->format("Y");
//            $year_for_report = date('Y', strtotime($report_for_fiscal_year->end_date));
        } else {
            $date = DateTime::createFromFormat("Y-m-d", $report_for_fiscal_year->start_date);
            $year_for_report = $date->format("Y");
//            $year_for_report = date('Y', strtotime($report_for_fiscal_year->start_date));
        }
        $last_day_of_quater = $this->getTotalNumberOfDaysByMonth($report_for_quater[1], $year_for_report);

        $quater_start_date = $year_for_report . '-' . $report_for_quater[0] . '-1';
        $quater_end_date = $year_for_report . '-' . $report_for_quater[1] . '-' . $last_day_of_quater;

        $quater_start_date_en = BSDateHelper::BsToAd('-', $quater_start_date);
        $quater_end_date_en = BSDateHelper::BsToAd('-', $quater_end_date);
    }

    public function getTotalNumberOfDaysByMonth(int $month, int $year)
    {
        $last_two_digits = $year - 2000;
        $month = intval($month);

        $months = $this->dates[$last_two_digits];
        return $months[$month];
    }

    public function depositOrgBranch(Request $request)
    {
        $data['fiscal_years'] = FiscalYear::all();

        $deposits = Deposit::query();
        $deposits = $deposits->withoutGlobalScope('is_pending');

        if (!empty($request->fiscal_year_id) && empty($request->start_date_en)) {
            $selectedFiscalYear = FiscalYear::find($request->fiscal_year_id);
            if (!empty($selectedFiscalYear)) {
                $deposits = $deposits->where(function ($query) use ($selectedFiscalYear) {
                    $query->where([['trans_date_en', '>=', $selectedFiscalYear->start_date_en], ['mature_date_en', '<=', $selectedFiscalYear->end_date_en]]);
                    $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->start_date_en], ['mature_date_en', '>=', $selectedFiscalYear->start_date_en]]);
                    $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->end_date_en], ['mature_date_en', '>=', $selectedFiscalYear->end_date_en]]);
                    $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->start_date_en], ['mature_date_en', '>=', $selectedFiscalYear->end_date_en]]);
                });
            }
        }
        if (!empty($request->start_date_en)) {
            $start_date_en = $request->start_date_en;
            $end_date_en = date('Y-m-d');
            if (!empty($request->end_date_en)) {
                $end_date_en = $request->end_date_en;
            }
            $deposits = $deposits->where(function ($query) use ($start_date_en, $end_date_en) {
                $query->where([['trans_date_en', '>=', $start_date_en], ['mature_date_en', '<=', $end_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $start_date_en], ['mature_date_en', '>=', $start_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $end_date_en], ['mature_date_en', '>=', $end_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $start_date_en], ['mature_date_en', '>=', $end_date_en]]);
            });
        }

        $deposits = $deposits->with(['withdraw' => function ($query) use ($request) {
            if (!empty($request->fiscal_year_id) && empty($request->start_date_en)) {
                $selectedFiscalYear = FiscalYear::find($request->fiscal_year_id);
                if (!empty($selectedFiscalYear)) {
                    $query->where('withdrawdate_en', '>=', $selectedFiscalYear->start_date_en);
                    $query->where('withdrawdate_en', '<=', $selectedFiscalYear->end_date_en);
                }
            }

            if (!empty($request->start_date_en)) {
                $start_date_en = $request->start_date_en;
                $end_date_en = date('Y-m-d');
                if (!empty($request->end_date_en)) {
                    $end_date_en = $request->end_date_en;
                }
                $query->where('withdrawdate_en', '>=', $start_date_en);
                $query->where('withdrawdate_en', '<=', $end_date_en);
            }
        }, 'child' => function ($query) use ($request) {
            $query->withoutGlobalScope('is_pending');
            if (!empty($request->fiscal_year_id) && empty($request->start_date_en)) {
                $selectedFiscalYear = FiscalYear::find($request->fiscal_year_id);
                $query->where([['trans_date_en', '>=', $selectedFiscalYear->start_date_en], ['mature_date_en', '<=', $selectedFiscalYear->end_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->start_date_en], ['mature_date_en', '>=', $selectedFiscalYear->start_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->end_date_en], ['mature_date_en', '>=', $selectedFiscalYear->end_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->start_date_en], ['mature_date_en', '>=', $selectedFiscalYear->end_date_en]]);
            }

            if (!empty($request->start_date_en)) {
                $start_date_en = $request->start_date_en;
                $end_date_en = date('Y-m-d');
                if (!empty($request->end_date_en)) {
                    $end_date_en = $request->end_date_en;
                }
                $query->where([['trans_date_en', '>=', $start_date_en], ['mature_date_en', '<=', $end_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $start_date_en], ['mature_date_en', '>=', $start_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $end_date_en], ['mature_date_en', '>=', $end_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $start_date_en], ['mature_date_en', '>=', $end_date_en]]);
            }
        }])->get();

        $details = [];
        $organization_branches = OrganizationBranch::pluck('branch_name', 'id');
        $i = 0;
        $total_deposits = 0;
        foreach ($organization_branches as $id => $organization_branch) {
            $details[$i]['organization_branch'] = $organization_branch;
            $details[$i]['total_deposit'] = $deposits->where('status', '!=', 4)->where('status', '!=', 5)->where('organization_branch_id', $id)->sum('deposit_amount') +
                $deposits->where('child', null)->where('status', 4)->where('organization_branch_id', $id)->sum('deposit_amount') + $deposits->where('withdraw', null)->where('status', 5)->where('organization_branch_id', $id)->sum('deposit_amount');;
            $details[$i]['estimated_earning'] = '';
            $total_deposits += $details[$i]['total_deposit'];
            $i++;
        }
        $data['details'] = $details;
        $data['total_deposits'] = $total_deposits;
        $data['organization_branches'] = $organization_branches;

        return view('report.organization-branch-deposit', $data);
    }

    public function total_deposit_report(Request $request)
    {
        $deposit_id = InvestmentType::InvestmenttypeDeposit();
        $investment_institutions = InvestmentInstitution::whereHas('deposit', function ($query) {
            $query->withoutGlobalScope('is_pending');
        })->get();

        $investment = InvestmentType::findOrFail($deposit_id);
        $data['institutions'] = $investment_institutions->pluck('institution_name', 'id');
        $data['investment_subtypes'] = $investment->investment_subtype->pluck('name', 'id');


        $deposits = $this->getDepositRecord($request->institution_id, $request->fiscal_year_id, $request->start_date_en, $request->end_date_en,
            [], null, null, null, null,
            null, null, true, $request->investment_subtype_id, null)['deposits'];
        if ($request->fresh_only == 1) {
            $deposits = $deposits->where('fiscal_year_id', $request->fiscal_year_id);
            $deposits = $deposits->where('parent_id', null);
        }
        $fiscals = $this->fiscal_years;
        $data['fiscal_years'] = $fiscals;

        $deposit_institutions = $deposits->groupBy('institute.institution_name');
        $details = [];
        $i = 0;
        $total_deposit = 0;
        $no_of_deposit = 0;
        if ($request->fresh_only == 1) {
            foreach ($deposit_institutions as $institution_name => $temp_deposit) {
                $details[$i]['institution_name'] = $institution_name;
                $details[$i]['total_deposit'] = $temp_deposit->sum('deposit_amount');
                $details[$i]['deposit_count'] = $temp_deposit->count();
                $total_deposit += $details[$i]['total_deposit'];
                $no_of_deposit += $details[$i]['deposit_count'];
                $i++;
            }
        } else {
            foreach ($deposit_institutions as $institution_name => $temp_deposit) {
                $details[$i]['institution_name'] = $institution_name;
                $details[$i]['total_deposit'] = $temp_deposit->where('status', '!=', 4)->where('status', '!=', 5)->sum('deposit_amount') + $temp_deposit->where('child', null)->where('status', 4)->sum('deposit_amount') + $temp_deposit->where('withdraw', null)->where('status', 5)->sum('deposit_amount');
                $details[$i]['deposit_count'] = $temp_deposit->where('status', '!=', 4)->where('status', '!=', 5)->count() + $temp_deposit->where('child', null)->where('status', 4)->count() + $temp_deposit->where('withdraw', null)->where('status', 5)->count();
                $total_deposit += $details[$i]['total_deposit'];
                $no_of_deposit += $details[$i]['deposit_count'];
                $i++;
            }
        }

        $data['details'] = $details;
        $data['total_deposit'] = $total_deposit;
        $data['no_of_deposit'] = $no_of_deposit;
        return view('report.total_deposit_report', $data);
    }

    public function total_deposit_report_excel(Request $request)
    {
        $deposits = Deposit::withoutGlobalScope('is_pending')->whereIn('status', [1, 2, 4]);
        $input = Input::all();
        $fiscals = $this->fiscal_years;
        $data['fiscal_years'] = $fiscals;

        $deposit_id = InvestmentType::InvestmenttypeDeposit();
        $investment = InvestmentType::findOrFail($deposit_id);
        $data['institutions'] = $investment->invest_inst->sortBy('institution_name')->pluck('institution_name', 'id');
        $data['investment_subtypes'] = $investment->investment_subtype->pluck('name', 'id');
        if (!empty($request->institution_id)) {
            $deposits = $deposits->where('institution_id', $request->institution_id);
        }
        if (!empty($request->start_date_en)) {
            $deposits = $deposits->where('trans_date_en', '>=', $request->start_date_en);
        }
        if (!empty($request->end_date_en)) {
            $deposits = $deposits->where('trans_date_en', '<=', $request->end_date_en);
        }
        if (!empty($request->fiscal_year_id)) {
            $deposits = $deposits->where('fiscal_year_id', $request->fiscal_year_id);
        }
        if (!empty($request->investment_subtype_id)) {
            $deposits = $deposits->where('investment_subtype_id', $request->investment_subtype_id);
        }
        if (isset($request->fresh_only)) {
            $deposits = $deposits->where('parent_id', '=', null);
        }
        $data['deposits'] = $deposits->selectRaw('*, sum(deposit_amount) as total_deposit')->groupBy('institution_id')->get();

        return Excel::create('totaldeposit', function ($excel) use ($data) {
            $excel->sheet('mySheet', function ($sheet) use ($data) {
                $sheet->cell('A1', function ($cell) {
                    $cell->setValue('Bank')->setFontWeight('bold');
                });
                $sheet->cell('B1', function ($cell) {
                    $cell->setValue('Total Deposit')->setFontWeight('bold');
                });
                if (!empty($data)) {
                    $i = 1;
                    $total = 0;
                    foreach ($data['deposits'] as $value) {
                        $i = $i + 1;
                        $sheet->setBorder('A' . $i . ':B' . $i, 'thin');
                        $total += $value->total_deposit;
                        $sheet->cell('A' . $i, $value->institute->institution_name);
                        $sheet->cell('B' . $i, $value->total_deposit);
                    }
                    $to = $i + 1;
                    $sheet->cell('A' . $to, function ($cell) {
                        $cell->setValue('Grand Total')->setFontWeight('bold');
                    });
                    $sheet->cell('B' . $to, $total);
                }
            });
        })->download('xlsx');
    }

    public function freshDeposit(Request $request)
    {
        $data['fiscal_years'] = FiscalYear::all();
        if ($request->fiscal_year_id) {
            $selectedFiscalYear = $data['fiscal_years']->where('id', $request->fiscal_year_id)->first();
        } else {
            $selectedFiscalYear = $data['fiscal_years']->where('status', 1)->first();
        }

        $deposits = $this->getDepositRecord($request->institution_id, $selectedFiscalYear->id, null, null,
            [], null, null, null, $request->branch_id,
            null, null, true, $request->investment_subtype_id, $request->organization_branch_id)['deposits'];
        $withdrawDeposits = clone($deposits);
        $renewDeposits = clone($deposits);
        $data['deposits'] = $deposits->where('parent_id', null)->where('fiscal_year_id', $selectedFiscalYear->id);
        $data['renews'] = $deposits->where('child', '<>', null);
        $data['withdraws'] = $withdrawDeposits->where('withdraw', '<>', null);
        if (!empty($request->export)) {
            Excel::create('Deposit Report', function ($excel) use ($data) {
                $excel->sheet('Fresh Deposits', function ($sheet) use ($data) {
                    $sheet->freezeFirstRow();
                    $sheet->loadView('deposit.freshdeposit.placement', $data);
                });

                $excel->sheet('Renew Deposits', function ($sheet) use ($data) {
                    $sheet->freezeFirstRow();
                    $sheet->loadView('deposit.freshdeposit.renew', $data);
                });

                $excel->sheet('Withdraw Deposits', function ($sheet) use ($data) {
                    $sheet->freezeFirstRow();
                    $sheet->loadView('deposit.freshdeposit.withdraw', $data);
                });
            })->download('xlsx');
        }
        $deposit_id = InvestmentType::InvestmenttypeDeposit();
        $investment = InvestmentType::with('invest_inst', 'investment_subtype')->findOrFail($deposit_id);
        $data['branches'] = BankBranch::pluck('branch_name', 'id');
        $data['institutes'] = $investment->invest_inst->sortBy('institution_name')->pluck('institution_name', 'id');
        $data['investment_subtypes'] = $investment->investment_subtype->pluck('name', 'id');
        $data['organization_branches'] = OrganizationBranch::pluck('branch_name', 'id');
        return view('deposit.freshdeposit', $data);
    }

    public function depositBankWiseSummary(Request $request)
    {
        $institutions = InvestmentInstitution::where('invest_type_id', 2)->get();
        $institutions = InvestmentInstitution::where('invest_type_id', 2)->where('invest_group_id', 4)->get();

        $activeFiscalYear = FiscalYear::find(2);
        $previous_fiscal_year_date = date('Y-m-d', strtotime('-60 days', strtotime($activeFiscalYear->start_date_en)));
        $previousFiscalYear = FiscalYear::where('start_date_en', '<=', $previous_fiscal_year_date)->where('end_date_en', '>=', $previous_fiscal_year_date)->first();

        $openingDeposits = Deposit::query();
        if (!empty($request->bank_institution_id)) {
            $openingDeposits = $openingDeposits->where('institution_id', $request->bank_institution_id);
        }

        if (!empty($request->ledger_deposit_type) && empty($request->bank_institution_id)) {
            $openingDeposits = $openingDeposits->where('investment_subtype_id', $request->ledger_deposit_type);
        }

        $openingDeposits = $openingDeposits->withoutGlobalScope('is_pending');
        $openingDeposits = $openingDeposits->where(function ($query) use ($previousFiscalYear) {
            $query->where([['trans_date_en', '>=', $previousFiscalYear->start_date_en], ['mature_date_en', '<=', $previousFiscalYear->end_date_en]]);
            $query->orWhere([['trans_date_en', '<=', $previousFiscalYear->start_date_en], ['mature_date_en', '>=', $previousFiscalYear->start_date_en]]);
            $query->orWhere([['trans_date_en', '<=', $previousFiscalYear->end_date_en], ['mature_date_en', '>=', $previousFiscalYear->end_date_en]]);
            $query->orWhere([['trans_date_en', '<=', $previousFiscalYear->start_date_en], ['mature_date_en', '>=', $previousFiscalYear->end_date_en]]);
        });

        $openingDeposits = $openingDeposits->with(['child' => function ($query) use ($previousFiscalYear) {
            $query->where([['trans_date_en', '>=', $previousFiscalYear->start_date_en], ['mature_date_en', '<=', $previousFiscalYear->end_date_en]]);
            $query->orWhere([['trans_date_en', '<=', $previousFiscalYear->start_date_en], ['mature_date_en', '>=', $previousFiscalYear->start_date_en]]);
            $query->orWhere([['trans_date_en', '<=', $previousFiscalYear->end_date_en], ['mature_date_en', '>=', $previousFiscalYear->end_date_en]]);
            $query->orWhere([['trans_date_en', '<=', $previousFiscalYear->start_date_en], ['mature_date_en', '>=', $previousFiscalYear->end_date_en]]);
            $query->withoutGlobalScope('is_pending');

        }, 'institute' => function ($query) {
            $query->with('mergedTo');
        }, 'withdraw' => function ($query) use ($previousFiscalYear) {
            if (!empty($previousFiscalYear)) {
                $query->where('withdrawdate_en', '>=', $previousFiscalYear->start_date_en);
                $query->where('withdrawdate_en', '<=', $previousFiscalYear->end_date_en);
            }
        }])->get();
        $data['opening_balance'] = $openingDeposits->where('status', '!=', 4)->where('status', '!=', 5)->sum('deposit_amount')
            + $openingDeposits->where('child', null)->where('status', 4)->sum('deposit_amount')
            + $openingDeposits->where('withdraw', null)->where('status', 5)->sum('deposit_amount');

        $placements = Deposit::withoutGlobalScope('is_pending')->where('trans_date_en', '>=', $activeFiscalYear->start_date_en)
            ->where('trans_date_en', '<=', $activeFiscalYear->end_date_en)
            ->where('parent_id', '=', null)
            ->with('institute', 'deposit_type', 'branch');

        if (!empty($request->bank_institution_id)) {
            $placements = $placements->where('institution_id', $request->bank_institution_id);
        }

        if (!empty($request->ledger_deposit_type) && empty($request->bank_institution_id)) {
            $placements = $placements->where('investment_subtype_id', $request->ledger_deposit_type);
        }
        $placements = $placements->get();
        $withdraws = DepositWithdraw::where('withdrawdate_en', '>=', $activeFiscalYear->start_date_en)
            ->where('withdrawdate_en', '<=', $activeFiscalYear->end_date_en)->withAndWhereHas('deposit', function ($query) use ($request) {
                if (!empty($request->bank_institution_id)) {
                    $query->where('institution_id', $request->bank_institution_id);
                }

                if (!empty($request->ledger_deposit_type) && empty($request->bank_institution_id)) {
                    $query->where('investment_subtype_id', $request->ledger_deposit_type);
                }

                $query->with('institute', 'deposit_type', 'branch');
                $query->withoutGlobalScope('is_pending');
            })->with('withdrawbranch')->get();
        $institutionAllRecords = [];
        foreach ($institutions as $institution) {
            $institutionOpeningBalance =
                $openingDeposits->where('institution_id', $institution->id)->where('status', '!=', 4)->where('status', '!=', 5)->sum('deposit_amount')
                + $openingDeposits->where('institution_id', $institution->id)->where('child', null)->where('status', 4)->sum('deposit_amount')
                + $openingDeposits->where('institution_id', $institution->id)->where('withdraw', null)->where('status', 5)->sum('deposit_amount');
            $institutionRecord['institution_name'] = $institution->institution_name;
            $institutionRecord['opening_balance'] = $institutionOpeningBalance;

            $institutionPlacements = $placements->where('institution_id', $institution->id);
            $records = [];
            $i = 0;
            foreach ($institutionPlacements as $placement) {
                $records[$i]['trans_date_en'] = $placement->trans_date_en ?? '';
                $records[$i]['dr_amount'] = $placement->deposit_amount ?? '';
                $records[$i]['cr_amount'] = 0;
                $i++;
            }
            $institutionWithdraws = $withdraws->where('deposit.institution_id', $institution->id);
            foreach ($institutionWithdraws as $withdraw) {
                $records[$i]['trans_date_en'] = $withdraw->withdrawdate_en ?? '';
                $records[$i]['dr_amount'] = 0;
                $records[$i]['cr_amount'] = $withdraw->deposit->deposit_amount ?? '';
                $i++;
            }
            $record_collections = collect($records);
            $institutionRecord['records'] = ($record_collections->sortBy('trans_date_en'));;

            $institutionAllRecords[] = $institutionRecord;
        }
        return view('report.deposit-bank-wise-detail-summary', compact('institutionAllRecords'));
    }

    public function activeDepositAtDate(Request $request)
    {
        $data['fiscal_years'] = FiscalYear::pluck('code', 'id');
        $investType = InvestmentType::investmenttypeDeposit();
        $data['institutions'] = InvestmentInstitution::where('invest_type_id', $investType)->pluck('institution_name', 'id');
        $data['invest_sub_types'] = InvestmentSubType::where('invest_type_id', $investType)->pluck('name', 'id');
        $data['branches'] = BankBranch::pluck('branch_name', 'id');
        $data['organizaion_branches'] = OrganizationBranch::pluck('branch_name', 'id');
        $data['current_fiscal_year_id'] = FiscalYear::where('status', 1)->first()->id;
        $selectedFiscalYear = $data['current_fiscal_year_id'];
        if (!empty($request->fiscal_year_id)) {
            $selectedFiscalYear = $request->fiscal_year_id;
        }
        $activeDeposits = $this->getDepositRecord($request->institution_id, $selectedFiscalYear, $request->start_date_en, $request->end_date_en, [],
            null, null, null, $request->branch_id, null, null, true,
            $request->invest_subtype_id, $request->organization_branch_id)['deposits'];

        // to check which deposits were active at that time period
        $activeDeposits = $activeDeposits->filter(function ($deposit) {
            if ($deposit->status == 1 || $deposit->status == 2 || $deposit->status == 3 || ($deposit->status == 4 && $deposit->child == null) || ($deposit->status == 5 && $deposit->withdraw == null)) {
                return true;
            } else {
                return false;
            }
        });

        $data['activeDeposits'] = $activeDeposits;
        $data['userOrganization'] = UserOrganization::first();
        return view('report.active-deposit-at-date', $data);
    }

    public function activeDepositAtDateDownloadExcel(Request $request)
    {
        $currentFiscalYear = FiscalYear::where('status', 1)->first()->id;
        $selectedFiscalYear = $currentFiscalYear;
        if (!empty($request->fiscal_year_id)) {
            $selectedFiscalYear = $request->fiscal_year_id;
        }
        $activeDeposits = $this->getDepositRecord($request->institution_id, $selectedFiscalYear, $request->start_date_en, $request->end_date_en, [],
            null, null, null, null, null, null, true,
            $request->invest_subtype_id, null)['deposits'];


        // to check which deposits were active at that time period
        $activeDeposits = $activeDeposits->filter(function ($deposit) {
            if ($deposit->status == 1 || $deposit->status == 2 || $deposit->status == 3 || ($deposit->status == 4 && $deposit->child == null) || ($deposit->status == 5 && $deposit->withdraw == null)) {
                return true;
            } else {
                return false;
            }
        });

        $data['activeDeposits'] = $activeDeposits;
        $data['userOrganization'] = UserOrganization::first();
        Excel::create('Active Deposits', function ($excel) use ($data) {
            $excel->sheet('Active Deposits', function ($sheet) use ($data) {
                $sheet->freezeFirstRow();
                $sheet->loadView('report.active-deposit-at-date-table', $data);
            });
        })->download('xlsx');
    }

    public function matureTrack(Request $request)
    {
        $data['fiscal_years'] = FiscalYear::all();
        $deposit_id = InvestmentType::InvestmenttypeDeposit();
        $investment = InvestmentType::with('invest_inst', 'investment_subtype')->findOrFail($deposit_id);
        $data['branches'] = BankBranch::pluck('branch_name', 'id');
        $data['institutes'] = $investment->invest_inst->sortBy('institution_name')->pluck('institution_name', 'id');
        $data['investment_subtypes'] = $investment->investment_subtype->pluck('name', 'id');
        $data['organization_branches'] = OrganizationBranch::pluck('branch_name', 'id');
        if ($request->fiscal_year_id) {
            $selectedFiscalYear = $data['fiscal_years']->where('id', $request->fiscal_year_id)->first();
        } else {
            $selectedFiscalYear = $data['fiscal_years']->where('status', 1)->first();
        }
        $deposits = Deposit::query();
        $deposits->withoutGlobalScope('is_pending');

        if (!empty($selectedFiscalYear) && empty($request->start_date_en) && empty($request->end_date_en)) {
            if (!empty($selectedFiscalYear)) {
                $deposits = $deposits->where('mature_date_en', '>=', $selectedFiscalYear->start_date_en)->where('mature_date_en', '<=', $selectedFiscalYear->end_date_en);
            }
        }
        if (!empty($request->start_date_en)) {
            $deposits = $deposits->where('mature_date_en', '>=', $request->start_date_en);
        }

        if (!empty($request->end_date_en)) {
            $deposits = $deposits->where('mature_date_en', '<=', $request->end_date_en);
        }
        if (!empty($request->institution_id)) {
            $deposits = $deposits->where('institution_id', '=', $request->institution_id);
        }
        if (!empty($request->investment_subtype_id)) {
            $deposits = $deposits->where('investment_subtype_id', '=', $request->investment_subtype_id);
        }

        if (!empty($request->organization_branch_id)) {
            $deposits = $deposits->where('organization_branch_id', '=', $request->organization_branch_id);
        }
        if (!empty($request->branch_id)) {
            $deposits = $deposits->where('branch_id', $request->branch_id);
        }
        $order = 1;
        if ($request->selected_order) {
            $order = $request->selected_order;
        }
        if ($order == 1) {
            $deposits = $deposits->orderBy('mature_date_en');
        } else {
            $deposits = $deposits->orderBy('mature_date_en', 'DESC');
        }
        $number_of_years = $request->number_of_years ?? 1;
        $deposits = $deposits->with(['bank', 'branch', 'child' => function ($query) {
            $query->withoutGlobalScope('is_pending');
        }, 'deposit_type', 'fiscalyear', 'withdraw', 'institute', 'parent' => function ($query) {
            $query->with(['parent' => function ($query) {
                $query->with(['parent' => function ($query) {
                    $query->with(['parent' => function ($query) {
                        $query->with(['parent' => function ($query) {
                            $query->with(['parent' => function ($query) {
                                $query->with(['parent' => function ($query) {
                                    $query->with(['parent' => function ($query) {
                                        $query->with(['parent' => function ($query) {
                                            $query->with(['parent' => function ($query) {
                                            }]);
                                        }]);
                                    }]);
                                }]);
                            }]);
                        }]);
                    }]);
                }]);
            }]);
        }])->get();
        $data['deposits'] = $deposits;
        $data['number_of_years'] = $number_of_years;
        if (!empty($request->export)) {
            Excel::create('Mature Track', function ($excel) use ($data) {
                $excel->sheet('Mature Track', function ($sheet) use ($data) {
                    $sheet->freezeFirstRow();
                    $sheet->loadView('report.maturetrack.table', $data);
                });

            })->download('xlsx');
        }

        return view('report.maturetrack.view', $data);
    }


}
