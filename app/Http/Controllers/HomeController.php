<?php

namespace App\Http\Controllers;

use App\BankBranch;
use App\Bond;
use App\Deposit;
use App\DepositWithdraw;
use App\FiscalYear;
use App\Helpers\BSDateHelper;
use App\InvestmentGroup;
use App\InvestmentInstitution;
use App\InvestmentType;
use App\OrganizationBranch;
use App\Share;
use App\Staff;
use App\Traits\ServerShareRecords;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use League\Flysystem\SafeStorage;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$data['organization_codes'] = ['ADBL', 'BOKL'];
        $data['date'] = '2019-01-01';
        ServerShareRecords::fetchData('https://www.bmpinfology.xyz/investment/nepse/public/index.php/api/closing-values', $data);*/

        $fiscal_year = BSDateHelper::getCurrentFiscalYear();
        if (!is_null($fiscal_year)) {
            FiscalYear::where('status', '=', 1)->update(['status' => 0]);
            FiscalYear::where('code', '=', $fiscal_year)->update(['status' => 1]);
        } else {
            FiscalYear::where('status', '=', 1)->update(['status' => 0]);
        }
        $currentFiscalYear = FiscalYear::where('status', 1)->latest()->first();

        $data['bondtotal'] = Bond::whereIn('status', [1, 2])->sum('totalamount');
        $data['deposittotal'] = Deposit::withoutGlobalScope('is_pending')->whereIn('status', [1, 2, 3])->sum('deposit_amount');
        $data['sharetotal'] = Share::where('status', 1)->sum('total_amount');

        $data['grandtotal'] = $data['bondtotal'] + $data['deposittotal'] + $data['sharetotal'];

        if (!empty($data['bondtotal']) || !empty($data['deposittotal']) || !empty($data['sharetotal'])) {
            $data['bondper'] = round(($data['bondtotal'] / $data['grandtotal']) * 100, 2);
            $data['depositper'] = round(($data['deposittotal'] / $data['grandtotal']) * 100, 2);
            $data['shareper'] = round(($data['sharetotal'] / $data['grandtotal']) * 100, 2);

            $data['bonds_total'] = Bond::all()->count();
            if ($data['bonds_total'] != 0) {
                $data['bonds_alerts'] = Bond::where('status', 2)->count();
                $data['bond_alerts_per'] = ceil(($data['bonds_alerts'] / $data['bonds_total']) * 100);
            }

            $data['deposits_total'] = Deposit::withoutGlobalScope('is_pending')->count();
            if ($data['deposits_total'] != 0) {
                $data['deposits_alerts'] = Deposit::withoutGlobalScope('is_pending')->where('status', 2)->where('next_status', null)->count();
                $data['deposits_alerts_per'] = ceil(($data['deposits_alerts'] / $data['deposits_total']) * 100);
            }
        }

        $data['investment_groups'] = InvestmentGroup::with('deposit', 'share')->where('enable', '=', 1)->where('parent_id', '<>', null)->get();

        $data['deposit_total'] = Deposit::withoutGlobalScope('is_pending')->sum('deposit_amount');
        $data['renew_soon_lists'] = Deposit::with('institute')->withoutGlobalScope('is_pending')->where('status', 2)->where('next_status', '=', null)->take(10)->orderBy('mature_date_en', 'asc')->get();
        $data['expired_lists'] = Deposit::with('institute')->withoutGlobalScope('is_pending')->where('status', 3)->orderBy('mature_date_en', 'asc')->take(10)->get();
        $data['deposit_stats'] = Deposit::withoutGlobalScope('is_pending')->select(DB::raw('count(id) as count'), DB::raw('sum(deposit_amount) as total_deposit_amount'), DB::raw('sum(estimated_earning) as total_estimated_earning'), DB::raw('month(trans_date) as month'))
            ->where('fiscal_year_id', '=', $currentFiscalYear->id)
            ->where('parent_id', null)
            ->groupBy('month')
            ->get();

        $data['withdraw_stats'] = DB::table('deposit_withdraws')->join('deposits', 'deposits.id', '=', 'deposit_withdraws.deposit_id')
            ->select(DB::raw('month(withdrawdate) as month'), DB::raw('sum(deposits.deposit_amount) as withdrawn_amount'))
            ->where('withdrawdate_en', '>=', $currentFiscalYear->start_date_en)
            ->where('withdrawdate_en', '<=', $currentFiscalYear->end_date_en)
            ->groupBy('month')
            ->get();
        $data['max_main_graph'] = ($data['deposit_stats']->max('total_deposit_amount') > $data['withdraw_stats']->max('withdrawn_amount')) ? $data['deposit_stats']->max('total_deposit_amount') : $data['withdraw_stats']->max('withdrawn_amount');

        $data['nepali_fiscal_year_months'] = Config::get('constants.nepali_fiscal_year_months');


        /*$data['share_kitta_count'] = Share::with('share_price_last')->where('share_type_id', '<>', 6)
            ->select(DB::raw('sum(purchase_kitta) as purchase_kitta'), 'institution_code')->groupBy('institution_code')->get();*/
        $data['investment_institutions'] = InvestmentInstitution::where('invest_type_id', 3)->whereHas('shares')->with('latest_share_price')->withCount([
            'purchaseShares AS purchase_count' => function ($query) {
                $query->select(DB::raw("SUM(purchase_kitta) as purchase_count"));
            }
        ])->withCount([
            'saleShares AS sales_count' => function ($query) {
                $query->select(DB::raw("SUM(purchase_kitta) as sales_count"));
            }
        ])->get();


        $data['institution_stats'] = Deposit::withoutGlobalScope('is_pending')
            ->select('investment_institutions.institution_code', DB::raw('count(deposits.id) as count'), DB::raw('avg(interest_rate) as average_interest_rate'), DB::raw('sum(deposit_amount) as deposit_amount'), DB::raw('sum(estimated_earning) as estimated_earning'))
            ->join('investment_institutions', 'deposits.institution_id', '=', 'investment_institutions.id')
            ->where(function ($query) use ($currentFiscalYear) {
                $query->where([['trans_date_en', '>=', $currentFiscalYear->start_date_en], ['mature_date_en', '<=', $currentFiscalYear->end_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $currentFiscalYear->start_date_en], ['mature_date_en', '>=', $currentFiscalYear->start_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $currentFiscalYear->end_date_en], ['mature_date_en', '>=', $currentFiscalYear->end_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $currentFiscalYear->start_date_en], ['mature_date_en', '>=', $currentFiscalYear->end_date_en]]);
            })->whereIn('status', [1, 2, 3])
            ->orderBy('institution_code')
            ->groupBy('institution_id')
            ->get();

        return view('dashboard', $data);
    }

    public function update()
    {
        /*$shares = Share::get();
        $investment_institutions = InvestmentInstitution::where('invest_type_id', 3)->get();
        foreach ($shares as $share) {
            $invest_sub_type_id = $investment_institutions->where('institution_code', $share->institution_code)->first()->invest_subtype_id;
            $share->investment_subtype_id = $invest_sub_type_id;
            $share->save();
        }*/

        $deposits = Deposit::withoutGlobalScope('is_pending')->where('institution_id', '<>', null)->get();
        $investment_institutions = InvestmentInstitution::where('invest_type_id', 2)->get();
        foreach ($deposits as $deposit) {
            $institution = $investment_institutions->where('id', $deposit->institution_id)->first();
            if (empty($institution)) {
                dd($deposit);
            }
            if ($institution->invest_subtype_id == 1) {
                dd($institution);
            }
            $invest_sub_type_id = $institution->invest_subtype_id;
            $deposit->investment_subtype_id = $invest_sub_type_id;
            $deposit->save();
        }
    }

    public function artisanCall($command)
    {
        Artisan::call("investment:alert");
        return redirect()->back();
    }

    public function changeBankCode()
    {
        $investment_institutions = array(
            'Prabhu Bank Limited' => 'PRVU',
            'Rastriya Banijya Bank Limited' => 'RBB',
            'Nepal Bank' => 'NBL',
            'Agriculture Development Bank Limited' => 'ADBL',
            'Nabil Bank Limited' => 'NABIL',
            'Nepal Investment Bank Limited' => 'NIB',
            'Standard Chartered Bank Nepal Limited' => 'SCB',
            'Himalayan Bank Limited' => 'HBL',
            'Nepal SBI Bank Limited' => 'SBI',
            'Nepal Bangladesh Bank' => 'NBB',
            'Everest Bank Limited' => 'EBL',
            'Kumari Bank Limited' => 'KBL',
            'Bank of Kathmandu Limited' => 'BOK',
            'Global IME Bank Limited' => 'GBIME',
            'Citizens Bank International Limited' => 'CZBIL',
            'Prime Commercial Bank Limited' => 'PCBL',
            'Sunrise Bank Limited' => 'SRBL',
            'NMB Bank Limited' => 'NMB',
            'NIC Asia Bank Limited' => 'NICA',
            'Machhapuchhre Bank Limited' => 'MBL',
            'Mega Bank Nepal Limited' => 'MEGA',
            'Civil Bank Limited' => 'CBL',
            'Century Bank Limited' => 'CCBL',
            'Sanima Bank Limited' => 'SANIMA',
            'Laxmi Bank Limited' => 'LBL',
            'Janata Bank Nepal Limited' => 'JBNL',
            'Siddhartha Bank Limited' => 'SBL',
            'Nepal Credit & Commercial Bank Limited' => 'NCCB',
            'Narayani Development Bank Limited' => 'NABBC',
            'Sahayogi Bikas Bank Limited' => 'SBBLJ',
            'Karnali Bikash Bank Limited' => 'KRBL',
            'Excel Development Bank Limited' => 'EDBL',
            'Miteri Development Bank Limited' => 'MDB',
            'Tinau Bikas Bank Limited' => 'TNBL',
            'Muktinath Bikas Bank Ltd' => 'MNBBL',
            'Kankai Bikas Bank Limited' => 'KNBL',
            'Bhargab Bikas Bank Limited' => 'BHBL',
            'Corporate Development Bank Limited' => 'CORBL',
            'Kabeli Bikas Bank Limited' => 'KEBL',
            'Purnima Bikas Bank Limited' => 'PURBL',
            'Hamro Bikas Bank Limited' => 'HAMRO',
            'Kanchan Development Bank Limited' => 'KADBL',
            'Mission Development Bank Limited' => 'MIDBL',
            'Mount Makalu Development Bank Limited' => 'MMDBL',
            'Sindhu Bikas Bank Limited' => 'SINDU',
            'Sahara Development Bank Limited' => 'SHBL',
            'Nepal Community Development Bank Limited' => 'NCDB',
            'Salapa Development Bank Limited' => 'SALAPA',
            'Saptakoshi Development Bank Limited' => 'SKDBL',
            'Green Development Bank Limited' => 'GRDBL',
            'Shangri-la Development Bank Limited' => 'SADBL',
            'Deva Development Bank Limited' => 'DBBL',
            'Kailash Development Bank Limited' => 'KBBL',
            'Shine Resunga Development Bank Limited' => 'SHDBL',
            'Jyoti Bikas Bank Limited' => 'JBBL',
            'Garima Bikas Bank Limited' => 'GBBL',
            'Om Development Bank Limited' => 'ODBL',
            'Mahalaxmi Development Bank Limited' => 'MLBL',
            'Gandaki Bikas Bank Limited' => 'GDBL',
            'Lumbini Bikas Bank Limited' => 'LBBL',
            'Kamana Sewa Bikas Bank Limited' => 'KSBBL',
            'Western Development Bank Limited' => 'WDBL',
            'Nepal Finance Limited' => 'NFS',
            'Nepal Share Markets and Finance Limited' => 'NSM',
            'Goodwill Finance Limited' => 'GFCL',
            'Lalitpur Finance Co. Limited' => 'LFC',
            'United Finance Limited' => 'UFL',
            'Best Finance Limited' => 'BFC',
            'Progressive Finance Limited' => 'PFOFL',
            'Janaki Finance Co. Limited' => 'JFL',
            'Pokhara Finance Limited' => 'PFL',
            'Hathway Finance Limited' => 'HALTHW',
            'Multipurpose Finance Co. Ltd' => 'MPFL',
            'Shrijana Finance Limited' => 'SFFIL',
            'World Merchant Banking & Finance Limited' => 'WMBF',
            'Capital Merchant Banking & Finance Co. Limited' => 'CMB',
            'Crystal Finance Limited' => 'CFL',
            'Guheshworil Merchant Banking & Finance Limited' => 'GMFIL',
            'ICFC Finance Limited' => 'ICFC',
            'City Express Finance Co. Limited' => 'CEFL',
            'Manjushree Financial Institution Limited' => 'MFIL',
            'Jebil\'s Finance Limited' => 'JEFL',
            'Reliance Finance Limited' => 'RLFL',
            'Gurkhas Finance Limited' => 'GUFL',
            'Himalaya Finance Limited' => 'HFL',
            'Shree Investment & Finance Co. Ltd.' => 'SIFCL',
            'Central Finance Limited' => 'CFCL',
            'Sajha Bikas Bank Limited' => 'SAJHA',
            'Srijana Finance Ltd' => 'SFFIL'
        );
        $institutions = InvestmentInstitution::where('invest_type_id', 2)->get();
        foreach ($institutions as $institution) {
            if (isset($investment_institutions[$institution->institution_name])) {
                $institution->institution_code = $investment_institutions[$institution->institution_name];
                $institution->save();
            }
        }
    }

    public function importExcel(Request $request)
    {
        ini_set('memory_limit', -1);
        ini_set('max_execution_time', 10000);
        DB::beginTransaction();
        $path = $request->file('deposit_excel')->getRealPath();
        $datas = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {
//            $reader->formatDates(true);
        })->all();
        $details = [];
        $i = 0;
        $fiscal_year = FiscalYear::find(3);
        /*foreach ($datas as $data) {
            $deposit = Deposit::find($data['id']);
            if(empty($deposit->approved_by)){
                if ($deposit->interest_rate != $data['excel_rate']) {
                    $deposit->interest_rate = $data['excel_rate'];
                    $deposit->estimated_earning = ((($deposit->deposit_amount * $deposit->interest_rate) / (100 * 365)) * $deposit->days);
                    $deposit->save();
                }
            }
        }
        DB::commit();*/
        foreach ($datas as $data) {
            $data['transaction_date'] = date('Y-m-d', strtotime($data['transaction_date']));
            $data['mature_date'] = date('Y-m-d', strtotime($data['mature_date']));
            if (($data['transaction_date'] >= $fiscal_year->start_date_en && $data['mature_date'] <= $fiscal_year->end_date_en)
                || ($data['transaction_date'] <= $fiscal_year->start_date_en && $data['mature_date'] >= $fiscal_year->start_date_en)
                || ($data['transaction_date'] <= $fiscal_year->end_date_en && $data['mature_date'] >= $fiscal_year->end_date_en)
                || ($data['transaction_date'] <= $fiscal_year->start_date_en && $data['mature_date'] >= $fiscal_year->end_date_en)
            ) {
                $term = trim(strtolower($data['bank_name']));
                $input['institution_id'] = InvestmentInstitution::whereRaw('lower(institution_name) like (?)', ["{$term}"])->where('invest_type_id', '=', InvestmentType::InvestmenttypeDeposit())->first();
                if (!empty($input['institution_id'])) {
                    $input['institution_id'] = $input['institution_id']->id;
                } else {
                    $status = 'error';
                    $mesg = 'Error Occured! Invalid Bank on SN.' . $data['sn'] . '!';
                    return $this->errorRedirect($mesg, $status);
                }
                $found = false;
                $deposit = Deposit::query();
//                if (!empty($data['fd_number'])) {
//                    $deposit = $deposit->where('document_no', $data['fd_number']);
//                    $found = $deposit->exists();
//                    if($found){
//                        $found=$input['institution_id']===$deposit->first()->institution_id;
//                    }
//                }

                if (!$found) {
                    $deposit = $deposit->orWhere(function ($query) use ($input, $data) {
                        $query->where('institution_id', $input['institution_id']);
                        $query->whereDate('trans_date_en', $data['transaction_date']);
                        $query->where('deposit_amount', $data['amount']);
                    })->get();
                } else {
                    $deposit = $deposit->with('institute')->get();
                }

                try {

                    if ($deposit->count() == 1) {
                        $deposit = $deposit->first();
                        if ($deposit->interest_rate != $data['interest_rate']) {
                            $details[$i]['bank_name'] = $data['bank_name'];
                            $details[$i]['transaction_date'] = $data['transaction_date'];
                            $details[$i]['mature_date'] = $data['mature_date'];
                            $details[$i]['amount'] = $data['amount'];
                            $details[$i]['excel_interest_rate'] = $data['interest_rate'];
                            $details[$i]['system_interest_rate'] = $deposit->interest_rate;
                            $details[$i]['fd_number'] = $deposit->document_no;
                            $details[$i]['status'] = 'Found On System';
                            $details[$i]['id'] = $deposit->id;
                            if ($deposit->id == 640) {
                                dd($data, $deposit);
                            }
                            $details[$i]['transaction_date_system'] = $deposit->trans_date_en;
                            $details[$i]['mature_date_system'] = $deposit->mature_date_en;
                            $details[$i]['bank_system'] = $deposit->institute->institution_name ?? '';

                            if ($data['fd_number'] == "F1807389FD02 (009751)") {
                                dd($data, $deposit, $details[$i]);
                            }
                        }

                    } elseif ($deposit->count() == 0) {
                        //deposit- deposit not found
                        $details[$i]['bank_name'] = $data['bank_name'];
                        $details[$i]['transaction_date'] = $data['transaction_date'];
                        $details[$i]['mature_date'] = $data['mature_date'];
                        $details[$i]['amount'] = $data['amount'];
                        $details[$i]['excel_interest_rate'] = $data['interest_rate'];
                        $details[$i]['system_interest_rate'] = '';
                        $details[$i]['fd_number'] = $data['fd_number'];
                        $details[$i]['status'] = 'Not Found On System';
                        $details[$i]['id'] = '';
                        $details[$i]['transaction_date_system'] = "";
                        $details[$i]['mature_date_system'] = "";
                        $details[$i]['bank_system'] = '';
                    } else {
                        //multiple deposit of this information
                        $details[$i]['bank_name'] = $data['bank_name'];
                        $details[$i]['transaction_date'] = $data['transaction_date'];
                        $details[$i]['mature_date'] = $data['mature_date'];
                        $details[$i]['amount'] = $data['amount'];
                        $details[$i]['excel_interest_rate'] = $data['interest_rate'];
                        $details[$i]['system_interest_rate'] = '';
                        $details[$i]['fd_number'] = $data['fd_number'];
                        $details[$i]['status'] = 'Multiple Found On System - Manual Check All date';
                        $details[$i]['id'] = '';
                        $details[$i]['transaction_date_system'] = "";
                        $details[$i]['mature_date_system'] = "";
                        $details[$i]['bank_system'] = '';
                    }
                    $i++;
                } catch (\Exception $e) {
                    dd($e);
                }
            }
        }
        return view('testviews.nlginterest', compact('details'));
    }

    public function checkChild()
    {
        $depositsWithChild = Deposit::whereHas('withdraw')->update(['status' => 5]);
    }

    public function shareFiscalId()
    {
        $shares = Share::all();
        $fiscal_years = FiscalYear::get();
        foreach ($shares as $share) {
            $date = $share->trans_date_en;
            if (!empty($date)) {
                $fiscal_year = $fiscal_years->where('start_date_en', '<=', $date)->where('end_date_en', '>=', $date)->first();
                if (!empty($fiscal_year)) {
                    $share->fiscal_year_id = $fiscal_year->id;
                    $share->save();
                }
            }
        }
    }

    public function trialBalance(Request $request)
    {
        $activeFiscalYear = FiscalYear::find($request->ledger_fiscal_year);
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
            + $openingDeposits->where('withdraw', null)->where('status', 5)->sum('deposit_amount');;

        $placements = Deposit::withoutGlobalScope('is_pending')->where('trans_date_en', '>=', $activeFiscalYear->start_date_en)
            ->where('trans_date_en', '<=', $activeFiscalYear->end_date_en)->where('parent_id', '=', null)->with('institute', 'deposit_type', 'branch');

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
        $records = [];
        $i = 0;
        foreach ($placements as $placement) {
            $records[$i]['institute'] = $placement->institute->institution_name ?? '';
            $records[$i]['trans_date_en'] = $placement->trans_date_en ?? '';
            $records[$i]['dr_amount'] = $placement->deposit_amount ?? '';
            $records[$i]['cr_amount'] = 0;
            $records[$i]['deposit_type'] = $placement->deposit_type->name ?? '';
            $records[$i]['branch'] = $placement->branch->branch_name ?? '';
            $records[$i]['cheque_number'] = $placement->cheque_no ?? '';
            $i++;
        }
        foreach ($withdraws as $withdraw) {
            $records[$i]['institute'] = $withdraw->deposit->institute->institution_name ?? '';
            $records[$i]['trans_date_en'] = $withdraw->withdrawdate_en ?? '';
            $records[$i]['dr_amount'] = 0;
            $records[$i]['cr_amount'] = $withdraw->deposit->deposit_amount ?? '';
            $records[$i]['deposit_type'] = $withdraw->deposit->deposit_type->name ?? '';
            $records[$i]['branch'] = $withdraw->withdrawbranch->branch_name ?? '';
            $records[$i]['cheque_number'] = '';
            $i++;
        }
        $record_collections = collect($records);
        $data['record_collections'] = ($record_collections->sortBy('trans_date_en'));

        return view('testviews.trial-balance', $data);
    }

    public function test()
    {
        $mismatchCount = 0;
        $fiscal_years = FiscalYear::get();
        foreach ($fiscal_years as $fiscal_year) {
            $depositsFYMismatches = Deposit::where('trans_date_en', '>=', $fiscal_year->start_date_en)
                ->where('trans_date_en', '<=', $fiscal_year->end_date_en)->where('fiscal_year_id', '<>', $fiscal_year->id)
                ->update(['fiscal_year_id' => $fiscal_year->id]);

        }
        dd($mismatchCount);
    }

    public function uploadCkEditor(Request $request){
        if ($request->has('upload')) {
            $name = time() . '.' . $request->upload->getClientOriginalExtension();

            $file = $request->file('upload');
            $destinationPath = public_path('files');
            $file->move($destinationPath, $name);
        }

        $data['uploaded'] = 1;
        $data['fileName'] = $name;
        $data['url'] = asset('files/' . $name);
        return response()->json($data);
    }

}
