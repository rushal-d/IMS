<?php

namespace App\Http\Controllers;

use App\BankBranch;
use App\Deposit;
use App\DepositWithdraw;
use App\FiscalYear;
use App\Helpers\BSDateHelper;
use App\InterestEarnedEntry;
use App\InvestmentInstitution;
use App\InvestmentType;
use App\OrganizationBranch;
use App\Staff;
use App\Traits\DepositTrait;
use App\UploadedDocument;
use App\UserOrganization;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use MilanTarami\NumberToWordsConverter\Services\NumberToWords;

class DepositController extends Controller
{
    use DepositTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = Input::all();
        $data['show_index'] = 0;
        $deposits = '';
        $details = '';
        if ($_SERVER['REQUEST_URI'] == "/deposits/alerts") {
            $deposits = Deposit::with('fiscalyear', 'institute', 'branch', 'deposit_type')->where('status', 2)->get();
            $data['status_f'] = 2;
        }

        if (count($input) > 0) {

            $data['show_index'] = 1;
            if (!isset($input['status'])) {
                $input['status'] = [];
            }
            $response = $this->getDepositRecord($request->institution_id, $request->fiscal_year_id, $request->start_date_en, $request->end_date_en, $input['status'],
                $request->earmarked, $request->fd_document_locations, $request->staff_id, $request->branch_id, $request->mature_days, $request->fd_number,
                ($request->include_pending == 1), $request->investment_subtype_id, $request->organization_branch_id);
            $deposits = $response['deposits'];
            $details = $response['details'];
            // Get current page form url e.x. &page=1
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            // Create a new Laravel collection from the array data
            $itemCollection = collect($details);
            $data['totalCount'] = count($itemCollection);
            // Define how many items we want to be visible in each page
            $perPage = 50;

            // Slice the collection to get the items to display in current page
            $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

            // Create our paginator and pass it to the view
            $paginatedItems = new LengthAwarePaginator($currentPageItems, count($itemCollection), $perPage);

            // set url path for generted links
            $paginatedItems->setPath($request->url());

            $details = $paginatedItems;

            $renewed_next_fiscal_year = $deposits->where('child', null)->where('status', 4)->sum('deposit_amount');
            $withdrawn_next_fiscal_year = $deposits->where('withdraw', null)->where('status', 5)->sum('deposit_amount');
            $data['deposittotalamount'] = $deposits->where('status', '!=', 4)->where('status', '!=', 5)->sum('deposit_amount') + $renewed_next_fiscal_year + $withdrawn_next_fiscal_year;

            $data['depositestimated_earning'] = $deposits->where('status', '!=', 4)->where('status', '!=', 5)->sum('estimated_earning');
            $data['deposite_withdraw_total'] = DepositWithdraw::whereIn('deposit_id', $deposits->pluck('id')->toArray())->sum('withdraw_amount');
        }

        $deposit_id = InvestmentType::InvestmenttypeDeposit();

        $data['fiscal_years'] = FiscalYear::all();
        $investment = InvestmentType::findOrFail($deposit_id);

        $data['institutes'] = $investment->invest_inst->sortBy('institution_name')->pluck('institution_name', 'id');
        $data['banks'] = BankBranch::pluck('branch_name', 'id');
        $data['investment_subtypes'] = $investment->investment_subtype->pluck('name', 'id');
        $data['organization_branches'] = OrganizationBranch::pluck('branch_name', 'id');
        $data['earmarked_constants'] = Config::get('constants.earmarked');
        $data['deposit_statuses'] = Config::get('constants.deposit_status');
        $data['fd_document_locations'] = Config::get('constants.fd_document_lcoations');
        $data['mature_days_filter'] = Config::get('constants.mature_days_filter');
        $data['staffs'] = Staff::pluck('name', 'id');
        $data['userOrganization'] = UserOrganization::first();

        $input['redirect_type'] = 'normal';
        $parameters = http_build_query($input);


        return view('deposit.index', $data, compact('deposits', 'details', 'parameters'));
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $deposit_id = InvestmentType::InvestmenttypeDeposit();
        $investment = InvestmentType::findOrFail($deposit_id);
        $data['institutes'] = $investment->invest_inst->sortBy('institution_name');
        $data['investment_subtypes'] = $investment->investment_subtype;
        $data['bankbranches'] = BankBranch::all();
        $data['organization_branches'] = OrganizationBranch::all();
        $data['staffs'] = Staff::pluck('name', 'id');
        $data['interest_payment_methods'] = Config::get('constants.investment_payment_methods');
        $data['fd_locations'] = Config::get('constants.fd_document_lcoations');
        return view('deposit.create', $data);
    }

    public function renew($id)
    {
        $data['old_deposit'] = Deposit::findOrFail($id);
        $renewed_check = Deposit::withoutGlobalScope('is_pending')->where('parent_id', $id)->exists();
        if ($renewed_check) {
            $status = 'error';
            $mesg = 'Record Already Renewed! Please Check Again';

            $notification = array(
                'message' => $mesg,
                'alert-type' => $status,
            );
            return redirect()->back()->with($notification);
        }
        $deposit_id = InvestmentType::InvestmenttypeDeposit();
        $investment = InvestmentType::findOrFail($deposit_id);
        $data['institutes'] = $investment->invest_inst->sortBy('institution_name');
        $data['investment_subtypes'] = $investment->investment_subtype;
        $data['bankbranches'] = BankBranch::all();
        $next_day = strtotime($data['old_deposit']->mature_date_en);
        $data['new_transaction_start_en'] = date('Y-m-d', strtotime('+1 day', $next_day));
        $data['uploaded_documents'] = UploadedDocument::where('deposit_id', $data['old_deposit']->id)->get();
        $data['organization_branches'] = OrganizationBranch::all();
        $data['staffs'] = Staff::pluck('name', 'id');
        $data['interest_payment_methods'] = Config::get('constants.investment_payment_methods');
        $data['fd_locations'] = Config::get('constants.fd_document_lcoations');
        return view('deposit.renewdeposit', $data);
    }

    public function withdraw($id)
    {
        $investment_type_id = InvestmentType::InvestmenttypeDeposit();
        $investment = InvestmentType::findOrFail($investment_type_id);
        $data['institutes'] = $investment->invest_inst->sortBy('institution_name');
        $data['bankbranches'] = BankBranch::all();
        $data['deposit'] = Deposit::findOrFail($id);
        return view('deposit.withdrawdeposit', $data);
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
        $investment_institution = InvestmentInstitution::findOrFail($input['institution_id']);
        $organization = UserOrganization::first();
        try {
            DB::beginTransaction();
            $input['invest_group_id'] = $investment_institution->invest_group_id;
            $input['investment_subtype_id'] = $investment_institution->invest_subtype_id;
            $input['created_by_id'] = $user_id;
            $input['updated_by_id'] = NULL;

            if (!empty($input['trans_date_en'])) {
                $fiscalyear = FiscalYear::whereDate('start_date_en', '<=', $input['trans_date_en'])->whereDate('end_date_en', '>=', $input['trans_date_en'])->latest()->first();
                if (!empty($fiscalyear)) {
                    $input['fiscal_year_id'] = $fiscalyear->id;
                }
            }

            $validFields = ['fiscal_year_id', 'institution_id', 'branch_id', 'trans_date_en', 'trans_date', 'days', 'mature_date_en', 'mature_date', 'interest_rate', 'deposit_amount', 'interest_payment_method', 'organization_branch_id', 'document_no', 'invest_group_id', 'investment_subtype_id'
            ];
            foreach ($validFields as $value) {
                if (empty($input[$value])) {
                    $input['is_pending'] = 1;
                    break;
                }
            }
            if (isset($input['parent_id'])) {
                if (Deposit::withoutGlobalScope('is_pending')->where('parent_id', $input['parent_id'])->exists()) {
                    DB::rollBack();
                    $status = 'error';
                    $mesg = 'Record Already Renewed! Please Check Again';

                    $notification = array(
                        'message' => $mesg,
                        'alert-type' => $status,
                    );
                    return redirect()->route('deposit.index')->with($notification);
                }
                $deposit = Deposit::withoutGlobalScope('is_pending')->findOrFail($input['parent_id']);
                if (!empty($deposit)) {
                    if (empty($deposit->reference_number) && !empty($request->reference_number) && $organization->organization_code == '0415') {
                        $update['reference_number'] = $request->reference_number;
                    }
                    $update['status'] = 4;
                    $deposit->update($update);// status 4 for renew
                }


            }
            $input['bank_merger_id'] = null;
            if (!empty($investment_institution) && $investment_institution->is_merger == 1) {
                $mergerDate = $investment_institution->merger_date;
                if (!empty($input['mature_date_en'])) {
                    if (strtotime($input['mature_date_en']) >= strtotime($mergerDate)) {
                        $input['bank_merger_id'] = $investment_institution->bank_merger_id;
                    }
                }
            }

            $deposit = Deposit::create($input);
            $depositstatus = 1;

            if (!empty($deposit->mature_date_en)) {
                //check deposits expiry days
                $today_date = date('Y-m-d');
                $mature_date = strtotime($deposit->mature_date_en);
                $today = strtotime($today_date); //time to check alert days with today's date
                $datediff = $mature_date - $today;
                $expire_days = (int)floor(($datediff / (60 * 60 * 24)));
                $deposit->expiry_days = $expire_days;

                if ($expire_days <= 0) {
                    $depositstatus = 3;
                }
                if ($expire_days <= $deposit->alert_days and $expire_days > 0) {
                    $depositstatus = 2;
                }
            }

            $deposit->status = $depositstatus;
            $status_mesg = $deposit->save();

            if (!empty($input['docs'])) {
                foreach ($input['docs'] as $doc) {
                    $uploaded_document = new UploadedDocument();
                    $uploaded_document->deposit_id = $deposit->id;
                    $uploaded_document->name = $doc;
                    $uploaded_document->save();
                }
            }
        } catch (\Exception $e) {
            $status_mesg = false;
            DB::rollBack();
        }
        if ($status_mesg) {
            DB::commit();
        }

        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data added successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('deposit.edit', $deposit->id)->with($notification);
    }


    public function savewithdraw(Request $request)
    {
        $input = $request->all();
        $fiscal_year = FiscalYear::whereDate('start_date_en', '<=', $input['withdrawdate_en'])->where('end_date_en', '>=', $input['withdrawdate_en'])->first();
        $input['fiscal_year_id'] = $fiscal_year->id;
        Deposit::findOrFail($input['deposit_id'])->update(['status' => 5]);
        $input['withdraw_bank_id'] = $request->institution_id;
        $input['withdraw_bank_branch_id'] = $request->branch_id;
        $input['withdraw_account_no'] = $request->acc_no;
        $status_mesg = DepositWithdraw::create($input);


        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data updated successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('deposit.withdrawedit', $status_mesg->id)->with($notification);
    }

    public function withdraw_edit($id)
    {
        $data['withdraw'] = DepositWithdraw::find($id);
        if (!empty($data['withdraw']->approved_by)) {
            if (!Auth::user()->hasRole('administrator')) {
                $status = 'error';
                $mesg = 'Warning! Withdraw Already Approved! Only Administrator Role user can update.';
                $notification = array(
                    'message' => $mesg,
                    'alert-type' => $status,
                );
                return redirect()->back()->with($notification);
            }
        }


        $investment_type_id = InvestmentType::InvestmenttypeDeposit();
        $investment = InvestmentType::findOrFail($investment_type_id);
        $data['institutes'] = $investment->invest_inst->sortBy('institution_name');
        $data['bankbranches'] = BankBranch::all();
        $data['deposit'] = Deposit::findOrFail($data['withdraw']->deposit_id);

        return view('deposit.withdrawdeposit-edit', $data);
    }

    public function withdraw_update(Request $request, $id)
    {
        $input = $request->all();
//        dd($input);
        $fiscal_year = FiscalYear::whereDate('start_date_en', '<=', $input['withdrawdate_en'])->where('end_date_en', '>=', $input['withdrawdate_en'])->first();
        Deposit::findOrFail($input['deposit_id'])->update(['status' => 5, 'fiscal_year_id' => $fiscal_year->id]);
        $deposit_withdraw = DepositWithdraw::find($id);

        if (!empty($deposit_withdraw->approved_by)) {
            if (!Auth::user()->hasRole('administrator')) {
                $status = 'error';
                $mesg = 'Warning! Withdraw Already Approved! Only Administrator Role user can update.';
                $notification = array(
                    'message' => $mesg,
                    'alert-type' => $status,
                );
                return redirect()->back()->with($notification);
            }
        }
        $status_mesg = $deposit_withdraw->update($input);

        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data updated successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('deposit.withdrawedit', $deposit_withdraw->id)->with($notification);
    }

    public function withdraw_delete($id)
    {
        $deposit_withdraw = DepositWithdraw::find($id);
        $deposit = Deposit::find($deposit_withdraw->deposit_id);

        if ($this->check_status($deposit)) {
            $status_mesg = $deposit_withdraw->delete();
        }


        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data updated successfully' : 'Error Occured! Try Again!';
        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('deposit.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Deposit $deposit
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $deposit = Deposit::withoutGlobalScope('is_pending')->where('id', $id)->first();
        $interestearnings = InterestEarnedEntry::where('deposit_id', $deposit->id)->get();
        $uploaded_documents = UploadedDocument::where('deposit_id', $deposit->id)->get();
        $staffs = Staff::pluck('name', 'id');
        $i = 1;
        $fd_locations = Config::get('constants.fd_document_lcoations');

        $deposit_collection = collect([]);

        $parent = $deposit->parentWithoutGlobalScope;
        if (!empty($parent)) {
            $this->addParentDepositRecordHistory($deposit_collection, $parent);
        }
        $deposit_collection->push($deposit);

        $child = $deposit->childWithoutGlobalScope;
        if (!empty($child)) {
            $this->childWithoutGlobalScope($deposit_collection, $child);
        }

        return view('deposit.show', compact('deposit', 'interestearnings', 'uploaded_documents', 'i', 'staffs', 'fd_locations', 'deposit_collection'));
    }

    public function addParentDepositRecordHistory(&$deposit_collection, $deposit)
    {
        $deposit_collection->push($deposit);
        $parent = $deposit->parentWithoutGlobalScope;
        if (!empty($parent)) {
            $this->addParentDepositRecordHistory($deposit_collection, $parent);
        }
    }

    public function childWithoutGlobalScope(&$deposit_collection, $deposit)
    {
        $deposit_collection->push($deposit);
        $child = $deposit->childWithoutGlobalScope;
        if (!empty($child)) {
            $this->childWithoutGlobalScope($deposit_collection, $child);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Deposit $deposit
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

        $input = $request->all();
        $data['parameters'] = http_build_query($input);
        $deposit = Deposit::withoutGlobalScope('is_pending')->find($id);
        if (!empty($deposit->approved_by)) {
            if (!Auth::user()->hasRole('administrator')) {
                $status = 'error';
                $mesg = 'Warning! Deposit Already Approved! Only Administrator Role user can update.';
                $notification = array(
                    'message' => $mesg,
                    'alert-type' => $status,
                );
                return redirect()->back()->with($notification);
            }
        }
        $deposit_id = InvestmentType::InvestmenttypeDeposit();
        $investment = InvestmentType::findOrFail($deposit_id);
        $data['institutes'] = $investment->invest_inst->sortBy('institution_name');
        $data['investment_subtypes'] = $investment->investment_subtype;
        $data['bankbranches'] = BankBranch::all();
        $data['uploaded_documents'] = UploadedDocument::where('deposit_id', $deposit->id)->get();
        $data['organization_branches'] = OrganizationBranch::all();
        $data['staffs'] = Staff::pluck('name', 'id');
        $data['interest_payment_methods'] = Config::get('constants.investment_payment_methods');
        $data['fd_locations'] = Config::get('constants.fd_document_lcoations');
        return view('deposit.edit', $data, compact('deposit'));
    }

    public function placementLetter($id)
    {
        $deposit = Deposit::where('id', $id)->withoutGlobalScope('is_pending')->first();
        $money = new NumberToWords();
        $placementLetter = UserOrganization::all();
        if ($placementLetter->isEmpty()) {
            $placementLetter = "";
        } else {
            $placementLetter = $placementLetter->first()->placement_letter;
        }
        $months = floor(($deposit->days) / 30);
        $todays_date = Carbon::now()->format('Y-m-d');
        return view('deposit.placement-letter', ['deposit' => $deposit, 'money' => $money, 'placementLetter' => $placementLetter, 'months' => $months, 'todays_date' => $todays_date]);
    }

    public function placementLetter2(Request $request, $id)
    {
        $deposit = Deposit::where('id', $id)->withoutGlobalScope('is_pending')->first();
        $money = new NumberToWords();
        $placementLetter2 = UserOrganization::all();
        if ($placementLetter2->isEmpty()) {
            $placementLetter2 = "";
        } else {
            $placementLetter2 = $placementLetter2->first()->placement_letter2;
        }
        $months = floor(($deposit->days) / 30);
        $todays_date = Carbon::now()->format('Y-m-d');
        return view('deposit.placement-letter2', ['deposit' => $deposit, 'money' => $money, 'placementLetter2' => $placementLetter2, 'months' => $months, 'todays_date' => $todays_date]);
    }

    public function renewLetter($id)
    {
        $deposit = Deposit::where('id', $id)->withoutGlobalScope('is_pending')->first();
        $money = new NumberToWords();
        $renewLetter = UserOrganization::all();
        if ($renewLetter->isEmpty()) {
            $renewLetter = "";
        } else {
            $renewLetter = $renewLetter->first()->renew_letter;
        }
        $todays_date = Carbon::now()->format('Y-m-d');
        $months = floor(($deposit->days) / 30);
        return view('deposit.renew-letter', ['deposit' => $deposit, 'money' => $money, 'renewLetter' => $renewLetter, 'months' => $months, 'todays_date' => $todays_date]);
    }

    public function withdrawLetter($id)
    {
        $deposit = DepositWithdraw::where('id', $id)->withoutGlobalScope('is_pending')->first();
        $money = new NumberToWords();
        $todays_date = Carbon::now();
        $withdrawLetter = UserOrganization::all();
        if ($withdrawLetter->isEmpty()) {
            $withdrawLetter = "";
        } else {
            $withdrawLetter = $withdrawLetter->first()->withdraw_letter;
        }
        $todays_date = Carbon::now()->format('Y-m-d');
        return view('deposit.withdraw-letter', ['deposit' => $deposit, 'money' => $money, 'withdrawLetter' => $withdrawLetter, 'todays_date' => $todays_date]);
    }

    public function placementLetter1Update(Request $request, $id)
    {
        $letter = Deposit::withoutGlobalScope('is_pending')->find($id);
        $letter->placement_letter = $request->okay;
        $status_mesg = $letter->save();

        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data updated successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        if ($letter->is_pending == 0) {
            return redirect()->route('deposit.edit', $letter->id)->with($notification);
        } else {
            return redirect()->route('pending-deposit-edit', $letter->id)->with($notification);
        }
    }

    public function placementLetter2Update(Request $request, $id)
    {
        $letter = Deposit::withoutGlobalScope('is_pending')->find($id);
        $letter->placement_letter2 = $request->okay;
        $status_mesg = $letter->save();

        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data updated successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        if ($letter->is_pending == 0) {
            return redirect()->route('deposit.edit', $letter->id)->with($notification);
        } else {
            return redirect()->route('pending-deposit-edit', $letter->id)->with($notification);
        }
    }

    public function renewLetterUpdate(Request $request, $id)
    {
        $letter = Deposit::withoutGlobalScope('is_pending')->find($id);
        $letter->renew_letter = $request->okay;
        $status_mesg = $letter->save();

        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data updated successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        if ($letter->is_pending == 0) {
            return redirect()->route('deposit.edit', $letter->id)->with($notification);
        } else {
            return redirect()->route('pending-deposit-edit', $letter->id)->with($notification);
        }
    }

    public function withdrawLetterUpdate(Request $request, $id)
    {
        $letter = DepositWithdraw::withoutGlobalScope('is_pending')->find($id);
        $letter->withdraw_letter = $request->okay;
        $status_mesg = $letter->save();

        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data updated successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('deposit.withdrawedit', $letter->id);
    }

    public function completeLetter($id)
    {
        $deposit = Deposit::where('id', $id)->first();
        return view('deposit.complete', ['deposit' => $deposit]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Deposit $deposit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $deposit = Deposit::withoutGlobalScope('is_pending')->find($id);
        $deposit->is_pending = 0;
        $input = $request->all();
        $user_id = Auth::user()->id;
        if (!empty($input['trans_date_en'])) {
            $fiscalyear = FiscalYear::whereDate('start_date_en', '<=', $input['trans_date_en'])->whereDate('end_date_en', '>=', $input['trans_date_en'])->latest()->first();
            if (!empty($fiscalyear)) {
                $input['fiscal_year_id'] = $fiscalyear->id;
            }
        }
        $input['updated_by_id'] = $user_id;
        $investment_institution = InvestmentInstitution::findOrFail($input['institution_id']);
        $input['invest_group_id'] = $investment_institution->invest_group_id;
        $input['investment_subtype_id'] = $investment_institution->invest_subtype_id;

        $input['bank_merger_id'] = null;
        if (!empty($investment_institution) && $investment_institution->is_merger == 1) {
            $mergerDate = $investment_institution->merger_date;
            if (!empty($input['mature_date_en'])) {
                if (strtotime($input['mature_date_en']) >= strtotime($mergerDate)) {
                    $input['bank_merger_id'] = $investment_institution->bank_merger_id;
                }
            }
        }

        $deposit->update($input);

        $organization = UserOrganization::first();
        if ($organization->organization_code == '0415') {
            if (!empty($deposit->parent_id) && !empty($deposit->reference_number)) {
                $parent = Deposit::withoutGlobalScope('is_pending')->findOrFail($deposit->parent_id);
                if (!empty($parent) && empty($parent->reference_number)) {
                    $parent->reference_number = $deposit->reference_number;
                    $parent->save();
                }
            }
            //also update if there is no ref no in child record
            $child = Deposit::withoutGlobalScope('is_pending')->where('parent_id', $deposit->id)->first();
            if (!empty($child) && empty($child->reference_number) && !empty($deposit->reference_number)) {
                $child->reference_number = $deposit->reference_number;
                $child->save();
            }
        }


        if ($deposit->status != 5 && $deposit->status != 4) {
            //check deposits expiry days
            $today_date = date('Y-m-d');
            $depositstatus = 1;
            $mature_date = strtotime($deposit->mature_date_en);
            $today = strtotime($today_date); //time to check alert days with today's date
            $datediff = $mature_date - $today;
            $expire_days = (int)floor(($datediff / (60 * 60 * 24)));
            $deposit->expiry_days = $expire_days;

            if ($expire_days <= 0) {
                $depositstatus = 3;
            }
            if ($expire_days <= $deposit->alert_days and $expire_days > 0) {
                $depositstatus = 2;
            }
            $deposit->status = $depositstatus;
        }
        $status_mesg = $deposit->save();
        $uploaded_documents = UploadedDocument::where('deposit_id', $deposit->id)->delete();
        if (!empty($input['docs'])) {
            foreach ($input['docs'] as $doc) {
                $uploaded_document = new UploadedDocument();
                $uploaded_document->deposit_id = $deposit->id;
                $uploaded_document->name = $doc;
                $uploaded_document->save();
            }
        }

        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data updated Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );

        $parameters = $request->parameters;
        $redirectURL = route('deposit.edit', $deposit->id) . '?' . $parameters;

        return redirect($redirectURL)->with($notification);

//        if (isset($request->pending) && $request->pending == 1)//if from pending
//        {
//            return (!empty($request->page)) ? redirect()->route('pending-deposit', ['page' => $request->page])
//                ->with($notification) :
//                redirect()->route('pending-deposit')->with($notification);
//
//        } else {
//            return (!empty($request->page)) ? redirect()->route('deposit.index', ['page' => $request->page])->with($notification) :
//                redirect()->route('deposit.index')->with($notification);
//        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Deposit $deposit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            InterestEarnedEntry::where('deposit_id', $id)->delete();
            UploadedDocument::where('deposit_id', $id)->delete();
            $deposit = Deposit::with('parent')->withoutGlobalScope('is_pending')->find($id);
            if (!empty($deposit->parent)) {
                $parent = $deposit->parent;
                $today_date = date('Y-m-d');
                $depositstatus = 1;
                $mature_date = strtotime($parent->mature_date_en);
                $today = strtotime($today_date); //time to check alert days with today's date
                $datediff = $mature_date - $today;
                $expire_days = (int)floor(($datediff / (60 * 60 * 24)));
                $parent->expiry_days = $expire_days;

                if ($expire_days <= 0) {
                    $depositstatus = 3;
                }
                if ($expire_days <= $deposit->alert_days and $expire_days > 0) {
                    $depositstatus = 2;
                }
                $parent->status = $depositstatus;
                $parent->save();
            }
            $deposit->deleted_by_id = Auth::user()->id;
            $deposit->save();
            $status_mesg = $deposit->delete();
        } catch (\Exception $e) {
            DB::rollBack();
            $status_mesg = false;
        }
        if ($status_mesg) {
            DB::commit();
        }
        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Deleted Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->back()->with($notification);
    }

    public function premierExcelDownload(Request $request)
    {
        ini_set('max_execution_time', -1);
        ini_set('memory_limit', -1);
        $input = $request->all();
        if (!isset($input['status'])) {
            $input['status'] = [];
        }
        $response = $this->getDepositRecord($input['institution_id'], $input['fiscal_year_id'], $input['start_date_en'], $input['end_date_en'], $input['status'],
            $input['earmarked'], $input['fd_document_locations'], $input['staff_id'], $input['branch_id'], $input['mature_days'], $input['fd_number'],
            isset($input['include_pending']), $input['investment_subtype_id'], $input['organization_branch_id']);
        $deposits = $response['details'];
        DepositTrait::excelDownload($deposits);
    }

    public function check_status($deposit)
    {
        $today_date = date('Y-m-d');
        $depositstatus = 1;
        $mature_date = strtotime($deposit->mature_date_en);
        $today = strtotime($today_date); //time to check alert days with today's date
        $datediff = $mature_date - $today;
        $expire_days = (int)floor(($datediff / (60 * 60 * 24)));
        $deposit->expiry_days = $expire_days;

        if ($expire_days <= 0) {
            $depositstatus = 3;
        }
        if ($expire_days <= $deposit->alert_days and $expire_days > 0) {
            $depositstatus = 2;
        }
        $deposit->status = $depositstatus;
        return $deposit->save();
    }

    public function print(Request $request)
    {
        $data['staffs'] = Staff::all();
        $data['deposits'] = Deposit::all();
        $pdf = \PDF::loadView('deposit.print', $data);
        return $pdf->setPaper('a4')->setOrientation('landscape')->setOption('margin-left', 0)->setOption('margin-right', 0)->inline('deposit.pdf');
    }

    //excel import
    public function importExcel(Request $request)
    {
        ini_set('memory_limit', '4000M');
        ini_set('max_execution_time', 5000);
        DB::beginTransaction();
        try {
            $completeness = false;
            $path = $request->file('deposit_excel')->getRealPath();
            $datas = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {
                $reader->formatDates(false);
            })->all();

            $fiscal_years = FiscalYear::all();
            $excel_maps_database = array();
            $deposits_with_renew_status = array();
            $i = 0;
            $investment_institutions = InvestmentInstitution::all();
            foreach ($datas as $data) {
                $input = array();
                if ($data['sn'] == 'END') {
                    break;
                }
                $has_parent = false;

                if (!empty($data['parent_sn'])) {
                    $previous_deposit = Deposit::find($excel_maps_database[$data['parent_sn']]);
                    if ($previous_deposit->status != 4) { //if has parent id then the parent must hold renewed status
                        $previous_deposit->status = 4;
                        $previous_deposit->save();
                    }
                    $input['parent_id'] = $excel_maps_database[$data['parent_sn']];
                    $has_parent = true;
                }

                //Bank Name(Institution for Deposit)
                if ($has_parent && empty($data['bank_name'])) {
                    $input['institution_id'] = $previous_deposit->institution_id;
                } else {
                    //search institution ignore case
                    $term = trim(strtolower($data['bank_name']));
                    $input['institution_id'] = InvestmentInstitution::whereRaw('lower(institution_name) like (?)', ["{$term}"])->where('invest_type_id', '=', InvestmentType::InvestmenttypeDeposit())->first();
                    if (!empty($input['institution_id'])) {
                        $input['institution_id'] = $input['institution_id']->id;
                    } else {
                        $status = 'error';
                        $mesg = 'Error Occured! Invalid Bank on SN.' . $data['sn'] . '!';

                        return $this->errorRedirect($mesg, $status);
                    }
                }
                if ($has_parent && empty($data['bank_branch'])) {
                    $input['branch_id'] = $previous_deposit->branch_id;
                } else {
                    //search bank branch ignore case and if not found create the bank branch
                    $bank_branch = trim(strtolower($data['bank_branch']));
                    $input['branch_id'] = BankBranch::whereRaw('lower(branch_name) like (?)', ["{$bank_branch}"])->first();
                    if (!empty($input['branch_id'])) {
                        $input['branch_id'] = $input['branch_id']->id;
                    } else {
                        $new_bank_branch = new BankBranch();
                        $new_bank_branch->branch_name = trim($data['bank_branch']);
                        $new_bank_branch->save();
                        $input['branch_id'] = $new_bank_branch->id;
                    }
                }

                if ($has_parent && empty($data['organization_branch'])) {
                    $input['organization_branch_id'] = $previous_deposit->organization_branch_id;
                } else {

                    if (!empty($data['organization_branch'])) {
                        //search organization branch ignore case and if not found create the bank branch
                        $organization_branch = trim(strtolower($data['organization_branch']));
                        $input['organization_branch_id'] = OrganizationBranch::whereRaw('lower(branch_name) like (?)', ["{$organization_branch}"])->first();
                        if (!empty($input['organization_branch_id'])) {
                            $input['organization_branch_id'] = $input['organization_branch_id']->id;
                        } else {
                            $new_organization_branch = new OrganizationBranch();
                            $new_organization_branch->branch_name = trim($data['organization_branch']);
                            $new_organization_branch->save();
                            $input['organization_branch_id'] = $new_organization_branch->id;
                        }

                        if (!empty($data['staff_name'])) {
                            //search staff name ignore case with organization banch and if not found create it
                            $staff_name = trim(strtolower($data['staff_name']));
                            $staff = Staff::where('organization_branch_id', $input['organization_branch_id'])->whereRaw('lower(name) like (?)', ["{$staff_name}"])->first();
                            if (!empty($staff)) {
                                $input['staff_id'] = $staff->id;
                            } else {
                                $staff = new Staff();
                                $staff->name = trim($data['staff_name']);
                                $staff->organization_branch_id = $input['organization_branch_id'];
                                $staff->save();
                                $input['staff_id'] = $staff->id;
                            }
                        }
                    }
                }

                /*if ($has_parent && empty($data['deposit_type'])) {
                    $input['investment_subtype_id'] = $previous_deposit->investment_subtype_id;
                } else {
                    //search deposit type ignore case
                    $term = strtolower($data['deposit_type']);
                    $input['investment_subtype_id'] = InvestmentSubType::whereRaw('lower(name) like (?)', ["{$term}"])->where('invest_type_id', InvestmentType::InvestmenttypeDeposit())->first();
                    if (!empty($input['investment_subtype_id'])) {
                        $input['investment_subtype_id'] = $input['investment_subtype_id']->id;
                    } else {
                        DB::rollBack();
                        $status = 'error';
                        $mesg = 'Error Occured! Invalid Deposit Type on SN.' . $data['sn'] . '!';
                        return $this->errorRedirect($mesg, $status);
                    }
                }*/
                //Document Number
                if ($has_parent && empty($data['fd_number'])) {
                    $input['document_no'] = trim($previous_deposit->document_no);
                } else {
                    $input['document_no'] = trim($data['fd_number']) ?? null;
                }

                $input['bank_contact_person_name'] = trim($data['bank_contact_person']) ?? null;

                $payment_methods = ['Q' => 'quarterly', 'M' => 'monthly', 'MO' => 'monthly', 'MONTHLY' => 'monthly', 'Y' => 'yearly', 'H' => 'halfyearly'];
                //Interest Payment Method
                if ($has_parent && empty($data['interest_payment_method'])) {
                    $input['interest_payment_method'] = $previous_deposit->interest_payment_method;
                } else {
                    if (!empty($data['interest_payment_method'])) {
                        $input['interest_payment_method'] = $payment_methods[strtoupper($data['interest_payment_method'])];
                    }
                }
                //reference number
                if ($has_parent && empty($data['reference_number'])) {
                    $input['reference_number'] = $previous_deposit->reference_number;
                } else {
                    $input['reference_number'] = $data['reference_number'] ?? null;
                }
                //interest rate
                if ($has_parent && empty($data['interest_rate'])) {
                    $input['interest_rate'] = $previous_deposit->interest_rate;
                } else {
                    $input['interest_rate'] = $data['interest_rate'];
                }

                //cheque date entry
                if (!empty($data['cheque_date'])) {
                    $input['cheque_date'] = $data['cheque_date'];
                    $input['cheque_date_np'] = BSDateHelper::AdToBsEN('-', date('Y-m-d', strtotime($input['cheque_date'])));
                }

                //deposit amount
                if ($has_parent && empty($data['deposit_amount'])) {
                    $input['deposit_amount'] = $previous_deposit->deposit_amount;
                } else {
                    if (strcasecmp($data['status'], 'withdrawn') == 0) {
                        $input['deposit_amount'] = $data['withdrawn_amount'] ?? $data['deposit_amount'];
                    } else {
                        $input['deposit_amount'] = $data['deposit_amount'] ?? 0;
                    }
                }
                if (empty($input['deposit_amount'])) {
                    DB::rollBack();
                    $status = 'error';
                    $mesg = 'Error Occured! Invalid Deposit Amount on SN.' . $data['sn'] . '!';
                    return $this->errorRedirect($mesg, $status);
                }

                //Alert Days
                if ($has_parent && empty($data['alert_days'])) {
                    $input['alert_days'] = $previous_deposit->alert_days;
                } else if (empty($data['alert_days'])) {
                    $input['alert_days'] = 30; //default 30 days if empty
                } else {
                    $input['alert_days'] = $data['alert_days'];
                }

                //Earmarked
                if ($has_parent && empty($data['earmarked'])) {
                    $input['earmarked'] = $previous_deposit->earmarked;
                } else {
                    if (strcasecmp($data['earmarked'], 'yes') == 0) {
                        $earmarked = 1;
                    } else {
                        $earmarked = 0;
                    }
                    $input['earmarked'] = $earmarked;
                }

                //Interest Credited Bank
                if ($has_parent && empty($data['interest_credited_bank'])) {
                    $input['bank_id'] = $previous_deposit->bank_id;
                } else {
                    if (!empty($data['interest_credited_bank'])) {
                        //search institution ignore case
                        $term = strtolower(trim($data['interest_credited_bank']));
                        $input['bank_id'] = InvestmentInstitution::whereRaw('lower(institution_name) like (?)', ["{$term}"])->where('invest_type_id', '=', InvestmentType::InvestmenttypeDeposit())->first();
                        if (!empty($input['bank_id'])) {
                            $input['bank_id'] = $input['bank_id']->id;
                        } else {
                            DB::rollBack();
                            $status = 'error';
                            $mesg = 'Error Occured! Invalid Interest Credited Bank on SN.' . $data['sn'] . '!';
                            return $this->errorRedirect($mesg, $status);
                        }
                    }
                }

                //Interest Credited Bank Branch
                if ($has_parent && empty($data['interest_credited_bank_branch'])) {
                    $input['bank_branch_id'] = $previous_deposit->bank_branch_id;
                } else {
                    if (!empty($data['interest_credited_bank_branch'])) {
                        //search bank branch ignore case and if not found create the bank branch
                        $bank_branch = strtolower(trim($data['interest_credited_bank_branch']));
                        $input['bank_branch_id'] = BankBranch::whereRaw('lower(branch_name) like (?)', ["{$bank_branch}"])->first();
                        if (!empty($input['bank_branch_id'])) {
                            $input['bank_branch_id'] = $input['bank_branch_id']->id;
                        } else {
                            $new_bank_branch = new BankBranch();
                            $new_bank_branch->branch_name = trim($data['interest_credited_bank_branch']);
                            $new_bank_branch->save();
                            $input['bank_branch_id'] = $new_bank_branch->id;
                        }
                    }
                }

                //Account Number
                if ($has_parent && empty($data['account_number'])) {
                    $input['accountnumber'] = $previous_deposit->accountnumber;
                } else {
                    $input['accountnumber'] = $data['account_number'] ?? null;
                }


                $input['days'] = $data['days'] ?? null;

                if (empty($data['transaction_date']) || empty($data['mature_date'])) { //set pending if any of the date is not mentioned
                    $input['is_pending'] = 1;
                    $input['status'] = 1;
                    $status = 1;
                }

                if (!empty($data['transaction_date'])) {
                    $input['trans_date_en'] = date('Y-m-d', strtotime($data['transaction_date']));
                    if ($this->validateDate($input['trans_date_en'])) {
                        $input['trans_date'] = BSDateHelper::AdToBsEN('-', $input['trans_date_en']);
                    } else {
                        $input['trans_date'] = null;
                        $input['trans_date_en'] = null;
                        $input['is_pending'] = 1;
                        $input['status'] = 1;
                    }
                }

                if (!empty($data['mature_date'])) {
                    $input['mature_date_en'] = date('Y-m-d', strtotime($data['mature_date']));
                    if ($this->validateDate($input['mature_date_en'])) {
                        $input['mature_date'] = BSDateHelper::AdToBsEN('-', $input['mature_date_en']);
                    } else {
                        $input['mature_date_en'] = null;
                        $input['mature_date'] = null;
                        $input['is_pending'] = 1;
                        $input['status'] = 1;
                    }
                }

                if (!empty($data['mature_date']) && !empty($data['transaction_date']) && $this->validateDate($input['trans_date_en']) && $this->validateDate($input['mature_date_en'])) {
                    $input['fiscal_year_id'] = $fiscal_years->where('start_date_en', '<=', $input['trans_date_en'])->where('end_date_en', '>=', $input['trans_date_en'])->first();
                    if (!empty($input['fiscal_year_id'])) {
                        $input['fiscal_year_id'] = $input['fiscal_year_id']->id;
                    } else {
                        DB::rollBack();
                        $status = 'error';
                        $mesg = 'Error Occured! Fiscal Year Not Found on SN.' . $data['sn'] . '!';
                        return $this->errorRedirect($mesg, $status);
                    }
                    //calculate estimated earning
                    //calculate days by date difference
                    $days = ((Carbon::createFromFormat('Y-m-d', $input['mature_date_en']))->diffInDays(Carbon::createFromFormat('Y-m-d', $input['trans_date_en'])));

                    $input['estimated_earning'] = ((($input['deposit_amount'] * $input['interest_rate']) / (100 * 365)) * $days);
                    if (empty($input['days'])) {
                        $input['days'] = $days; //days from calculation
                    }

                    //check expiry
                    $today_date = date('Y-m-d');
                    $mature_date = strtotime($input['mature_date_en']);
                    $today = strtotime($today_date); //time to check alert days with today's date
                    $datediff = $mature_date - $today;

                    $input['expiry_days'] = (int)floor(($datediff / (60 * 60 * 24)));
                    if (strcasecmp($data['status'], 'active') == 0 || $data['status'] == '') {
                        $status = 1;
                        if ($input['expiry_days'] <= 0) {
                            $status = 3;
                        }
                        if ($input['expiry_days'] <= $input['alert_days'] and $input['expiry_days'] > 0) {
                            $status = 2; // renew soon
                        }
                    } elseif (strcasecmp($data['status'], 'expired') == 0) {
                        $status = 3;
                    } elseif (strcasecmp($data['status'], 'renewed') == 0) {
                        $status = 4;
                    } elseif (strcasecmp($data['status'], 'withdrawn') == 0) {
                        $status = 5;
                    } else {
                        DB::rollBack();
                        $status = 'error';
                        $mesg = 'Error Occured! Invalid Status on SN.' . $data['sn'] . '!';
                        return $this->errorRedirect($mesg, $status);
                    }
                }


                $input['status'] = $status;


                //dd($input);
                //save the FB receipt status
                $receipt_status = $data['receipt_status'] ?? '';
                $reciept_status_id = 0;
                if ($receipt_status == 'COPY') {
                    $reciept_status_id = 1;
                } else if (strtolower(trim($receipt_status)) == 'online') {
                    $reciept_status_id = 2;
                } else if (strtolower(trim($receipt_status)) == 'bsib') {
                    $reciept_status_id = 3;
                } else if (strtolower(trim($receipt_status)) == strtolower(env('ORG_CODE', 'Head Office'))) {
                    $reciept_status_id = 4;
                } else if (strtoupper(trim($receipt_status)) == "EMAIL") {
                    $reciept_status_id = 5;
                } else if (strtolower(trim($receipt_status)) == "returned") {
                    $reciept_status_id = 6;
                }
                $input['fd_document_current_location'] = $reciept_status_id;
                $input['notes'] = $data['notes'] ?? '';
                $input['narration'] = $data['remarks'] ?? '';

                $user_id = Auth::user()->id;
                $input['invest_group_id'] = $investment_institutions->where('id', $input['institution_id'])->last()->invest_group_id;
                $input['investment_subtype_id'] = $investment_institutions->where('id', $input['institution_id'])->last()->invest_subtype_id;
                $input['created_by_id'] = $user_id;
                $input['updated_by_id'] = $user_id;
                $deposit = Deposit::create($input);

                $excel_maps_database[$data['sn']] = $deposit->id;

                if ($status == 5) {
                    /*if (!empty($data['withdraw_date'])) {*/
                    $withdraw_deposit = new DepositWithdraw();
                    if (!empty($data['withdraw_date'])) {
                        $withdraw_deposit->withdrawdate_en = date('Y-m-d', strtotime($data['withdraw_date']));
                    } else {
                        $withdraw_deposit->withdrawdate_en = date('Y-m-d', strtotime($input['mature_date_en']));
                    }

                    $withdraw_deposit->withdrawdate = BSDateHelper::AdToBsEN('-', $withdraw_deposit->withdrawdate_en);
                    $withdraw_deposit->withdraw_amount = $input['deposit_amount'];
                    $withdraw_deposit->deposit_id = $deposit->id;
                    $withdraw_deposit->save();
                    /* } else {
                         DB::rollBack();
                         $status = 'error';
                         $mesg = 'Error Occured! Withdraw Date is empty or not valid on SN.' . $data['sn'] . '!';
                         return $this->errorRedirect($mesg, $status);
                     }*/
                }
                if ($deposit->status == 4) {
                    $deposits_with_renew_status[$i++] = $deposit->id;

                }
            }

            foreach ($deposits_with_renew_status as $renewed_deposit_id) {
                $check_parent = Deposit::withoutGlobalScope('is_pending')->where('parent_id', $renewed_deposit_id)->first();

                if (empty($check_parent)) {
                    $sn = array_search($renewed_deposit_id, $excel_maps_database);
                    $completeness = false;
                    DB::rollBack();
                    $status = 'error';
                    $mesg = 'Error Occured! Renewd Record not available of SN.' . $sn . '!';
                    return $this->errorRedirect($mesg, $status);
                }
            }
            $completeness = true;

        } catch (\Exception $e) {
            dd($e);
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
        return redirect()->route('deposit.index')->with($notification);

    }

    //nlg export code
    public function nlgExport(Request $request)
    {
        $deposits = Deposit::query();
        $selectedFiscalYear = FiscalYear::find($request->fiscal_year);
        if (!empty($selectedFiscalYear)) {
            $deposits = $deposits->where(function ($query) use ($selectedFiscalYear) {
                $query->where([['trans_date_en', '>=', $selectedFiscalYear->start_date_en], ['mature_date_en', '<=', $selectedFiscalYear->end_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->start_date_en], ['mature_date_en', '>=', $selectedFiscalYear->start_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->end_date_en], ['mature_date_en', '>=', $selectedFiscalYear->end_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->start_date_en], ['mature_date_en', '>=', $selectedFiscalYear->end_date_en]]);
            });
        }
        $deposits = $deposits->with(['child' => function ($query) use ($selectedFiscalYear) {
            $query->withoutGlobalScope('is_pending');
            $query->where([['trans_date_en', '>=', $selectedFiscalYear->start_date_en], ['mature_date_en', '<=', $selectedFiscalYear->end_date_en]]);
            $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->start_date_en], ['mature_date_en', '>=', $selectedFiscalYear->start_date_en]]);
            $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->end_date_en], ['mature_date_en', '>=', $selectedFiscalYear->end_date_en]]);
            $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->start_date_en], ['mature_date_en', '>=', $selectedFiscalYear->end_date_en]]);

        }, 'institute', 'bank', 'branch', 'deposit_type', 'fiscalyear', 'approvalUser', 'withdraw' => function ($query) use ($request) {
            $selectedFiscalYear = FiscalYear::find($request->fiscal_year);
            if (!empty($selectedFiscalYear)) {
                $query->where('withdrawdate_en', '>=', $selectedFiscalYear->start_date_en);
                $query->where('withdrawdate_en', '<=', $selectedFiscalYear->end_date_en);
            }
        }, 'actualEarning'])->withoutGlobalScope('is_pending')->get();

        $details = array(); //inorder to store the new deposit collections with the child deposits i.e renewed just after it
        $deposits_appeared = array(); //check if the deposit has already appared on the child list of previous deposit

        foreach ($deposits as $deposit) {
            //recursive function inorder to place the deposits together with renew
            $this->add_to_array($details, $deposits, $deposit, $deposits_appeared);
        }
        $deposit_records = [];
        foreach ($details as $deposit) {
            $record['bank_name'] = $deposit->institute->institution_name;
            $record['bank_branch'] = $deposit->branch->branch_name ?? '';
            $record['fd_number'] = $deposit->document_no;
            $record['start'] = $deposit->trans_date_en;
            $record['end'] = $deposit->mature_date_en;
            $record['amount'] = $deposit->deposit_amount;
            $record['rate'] = $deposit->interest_rate;
            $record['type'] = $deposit->deposit_type->name ?? '';
            $record['payable'] = $deposit->interest_payment_method ?? '';
            $record['organization_branch'] = $deposit->organization_branch->branch_name ?? '';
            $record['days'] = $deposit->days ?? '';
            $record['month'] = (int)($deposit->days / 30) ?? '';
            $record['mark'] = '';
            $record['cheque_no'] = $deposit->cheque_no;
            $interest_start_date = $deposit->trans_date_en;
            if (strtotime($deposit->trans_date_en) <= strtotime($selectedFiscalYear->start_date_en)) {
                $interest_start_date = $selectedFiscalYear->start_date_en;
            }
            $interest_end_date = $deposit->mature_date_en;
            if (strtotime($deposit->mature_date_en) >= strtotime($selectedFiscalYear->end_date_en)) {
                $interest_end_date = $selectedFiscalYear->end_date_en;
            }
            $record['interest_start'] = $interest_start_date;
            $record['interest_end'] = $interest_end_date;

            $days = ((Carbon::createFromFormat('Y-m-d', $interest_end_date))->diffInDays(Carbon::createFromFormat('Y-m-d', $interest_start_date))) + 1;
            $record['interest_days'] = $days;
            $record['earning'] = $deposit->deposit_amount * ($deposit->interest_rate / 100) * $days / 365;
            $record['approved_by'] = $deposit->approvalUser->name ?? '';
            $record['system_id'] = $deposit->id ?? '';
            $deposit_records[] = $record;
            if (!empty($deposit->child) || !empty($deposit->withdraw)) {
                $record['amount'] = '-' . $deposit->deposit_amount;
                $record['interest_start'] = '';
                $record['interest_end'] = '';

                $record['interest_days'] = '';
                $record['earning'] = '';
                $deposit_records[] = $record;
            }

        }
        return view('deposit.nlg', ['deposit_records' => $deposit_records]);

    }

    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }

    function errorRedirect($mesg, $status)
    {
        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->back()->with($notification);
    }

    public function nextStatusAjax(Request $request)
    {
        $next_status = Deposit::find($request->id);
        $next_status->next_status = $request->next_status;
        $next_status->next_interest_rate = $request->next_interest_rate;
        $next_status->save();
    }

    public function approveDeposit($id)
    {
        $deposit = Deposit::withoutGlobalScope('is_pending')->where('id', $id)->first();
        $status = false;
        if (!empty($deposit)) {
            $message = 'Approved By ' . Auth::user()->name;
            $deposit->approved_by = Auth::id();
            $deposit->approved_date = Carbon::now();
            $deposit->save();
            $status = true;
        }
        if ($status) {
            return response()->json($message);
        } else {
            return response()->json('Oops Something went wrong!');
        }
    }

    public function approveDepositWithdraw($id)
    {
        $deposit_withraw = DepositWithdraw::withoutGlobalScope('is_pending')->where('id', $id)->first();
        $status = false;
        if (!empty($deposit_withraw)) {
            $message = 'Approved By ' . Auth::user()->name;
            $deposit_withraw->approved_by = Auth::id();
            $deposit_withraw->approved_date = Carbon::now();
            $deposit_withraw->save();
            $status = true;
        }
        if ($status) {
            return response()->json($message);
        } else {
            return response()->json('Oops Something went wrong!');
        }
    }

    public function ledgerExport(Request $request)
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
        $data['previousFiscalYear'] = $previousFiscalYear;

        Excel::create('Ledger', function ($excel) use ($data) {

            $excel->sheet('Ledger', function ($sheet) use ($data) {
                $sheet->freezeFirstRow();
                $sheet->loadView('deposit.ledgerexport', $data);
            });

        })->download('xlsx');;
    }
}