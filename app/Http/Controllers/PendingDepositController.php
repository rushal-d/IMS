<?php

namespace App\Http\Controllers;

use App\BankBranch;
use App\Deposit;
use App\FiscalYear;
use App\InvestmentInstitution;
use App\InvestmentType;
use App\OrganizationBranch;
use App\UploadedDocument;
use App\Staff;
use App\Traits\DepositTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;

class PendingDepositController extends Controller
{
    public function index(Request $request)
    {
        $deposits = new Deposit();
        if (!empty($request->filter_by) && !empty($request->value)) {
            $value = $request->value;
            if ($request->filter_by == "organization_branch_id") {
                $value = OrganizationBranch::where('branch_name', 'LIKE', '%' . $value . '%')->orWhere('branch_code', 'LIKE', '%' . $value . '%')->latest()->first();
                if (!empty($value)) {
                    $value = $value->id;
                }
            } elseif ($request->filter_by == "institution_id") {
                $value = InvestmentInstitution::where([['institution_name', 'LIKE', '%' . $value . '%'], ['invest_type_id', '=', 2]])->orWhere([['institution_code', 'LIKE', '%' . $value . '%'], ['invest_type_id', '=', 2]])->latest()->first();
                if (!empty($value)) {
                    $value = $value->id;
                }
            }
            $deposits = $deposits->where($request->filter_by, 'LIKE', '%' . $value . '%');
        }
        if (!empty($request->createdat_from) && !empty($request->createdat_to)) {
            $deposits = $deposits->whereDate('created_at', '>=', $request->createdat_from)->whereDate('created_at', '<=', $request->createdat_to);
        } elseif (!empty($request->createdat_from)) {
            $deposits = $deposits->whereDate('created_at', '=', $request->createdat_from);
        }

        if (!empty($request->date_missing)) {
            $deposits = $deposits->where(function ($query) {
                $query->where('trans_date_en', null)->orWhere('mature_date_en', null);
            });
        }

        $deposits = $deposits->withoutGlobalScope('is_pending')->where('is_pending', 1)->latest()->paginate(20);
        $i = 1;
        $input = $request->all();

        $input['redirect_type'] = 'pending';
        $parameters = http_build_query($input);
        $filter_by = [
            'organization_branch_id' => 'Org branch',
            'institution_id' => 'Bank Name',
            'deposit_amount' => 'Amount',
            'voucher_number' => 'JV',
            'account_head' => 'Account Head',

        ];
        return view('pendingdeposit.index', compact('deposits', 'i', 'filter_by', 'parameters'));
    }

    public function excelDownload(Request $request)
    {
        $deposits = new Deposit();
        if (!empty($request->filter_by) && !empty($request->value)) {
            $value = $request->value;
            if ($request->filter_by == "organization_branch_id") {
                $value = OrganizationBranch::where('branch_name', 'LIKE', '%' . $value . '%')->orWhere('branch_code', 'LIKE', '%' . $value . '%')->latest()->first();
                if (!empty($value)) {
                    $value = $value->id;
                }
            } elseif ($request->filter_by == "institution_id") {
                $value = InvestmentInstitution::where([['institution_name', 'LIKE', '%' . $value . '%'], ['invest_type_id', '=', 2]])->orWhere([['institution_code', 'LIKE', '%' . $value . '%'], ['invest_type_id', '=', 2]])->latest()->first();
                if (!empty($value)) {
                    $value = $value->id;
                }
            }
            $deposits = $deposits->where($request->filter_by, 'LIKE', '%' . $value . '%');

        }

        $deposits = $deposits->withoutGlobalScope('is_pending')->with('actualEarning')->where('is_pending', 1)->latest()->get();
        DepositTrait::excelDownload($deposits);
    }

    public function create(Request $request)
    {
        $deposit_id = InvestmentType::InvestmenttypeDeposit();
        $data['fiscal_years'] = FiscalYear::all();
        $investment = InvestmentType::findOrFail($deposit_id);
        $data['institutes'] = $investment->invest_inst->sortBy('institution_name');
        $data['investment_subtypes'] = $investment->investment_subtype;
        $data['bankbranches'] = BankBranch::all();
        $data['organization_branches'] = OrganizationBranch::all();
        $data['staffs'] = Staff::pluck('name', 'id');
        $data['interest_payment_methods'] = Config::get('constants.investment_payment_methods');
        $data['fd_locations'] = Config::get('constants.fd_document_lcoations');
        return view('pendingdeposit.create', $data);
    }

    public function store(Request $request)
    {
        $input = Input::all();
        $user_id = Auth::user()->id;
        if (!empty($input['institution_id'])) {
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
        }
        if (!empty($input['trans_date_en'])) {
            $fiscalyear = FiscalYear::whereDate('start_date_en', '<=', $input['trans_date_en'])->whereDate('end_date_en', '>=', $input['trans_date_en'])->latest()->first();
            if (!empty($fiscalyear)) {
                $input['fiscal_year_id'] = $fiscalyear->id;
            }
        }

        $input['created_by_id'] = $user_id;
        $input['updated_by_id'] = NULL;

        $input['is_pending'] = 1;
        $deposit = Deposit::create($input);

        if (!empty($input['docs'])) {
            foreach ($input['docs'] as $doc) {
                $uploaded_document = new UploadedDocument();
                $uploaded_document->deposit_id = $deposit->id;
                $uploaded_document->name = $doc;
                $uploaded_document->save();
            }
        }

        $status = ($deposit) ? 'success' : 'error';
        $mesg = ($deposit) ? 'Data added successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('pending-deposit-edit', $deposit->id)->with($notification);
    }

    public function edit(Request $request, $id)
    {
        $input = $request->all();
        $data['parameters'] = http_build_query($input);

        $deposit = Deposit::withoutGlobalScope('is_pending')->find($id);
        $deposit_id = InvestmentType::InvestmenttypeDeposit();
        $data['fiscal_years'] = FiscalYear::all();
        $investment = InvestmentType::findOrFail($deposit_id);
        $data['institutes'] = $investment->invest_inst->sortBy('institution_name');
        $data['investment_subtypes'] = $investment->investment_subtype;
        $data['bankbranches'] = BankBranch::all();
        $data['uploaded_documents'] = UploadedDocument::where('deposit_id', $deposit->id)->get();
        $data['organization_branches'] = OrganizationBranch::all();
        $data['staffs'] = Staff::pluck('name', 'id');
        $data['interest_payment_methods'] = Config::get('constants.investment_payment_methods');
        $data['fd_locations'] = Config::get('constants.fd_document_lcoations');
        return view('pendingdeposit.edit', $data, compact('deposit'));
    }

    public function update(Request $request, $id)
    {
        $deposit = Deposit::withoutGlobalScope('is_pending')->find($id);
        $input = $request->all();
        if (!empty($input['institution_id'])) {
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
        }
        $deposit->update($input);

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
        if (!empty($input['trans_date_en'])) {
            $fiscalyear = FiscalYear::whereDate('start_date_en', '<=', $input['trans_date_en'])->whereDate('end_date_en', '>=', $input['trans_date_en'])->latest()->first();
            if (!empty($fiscalyear)) {
                $input['fiscal_year_id'] = $fiscalyear->id;
            }
        }

        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data updated Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        $parameters = $request->parameters;
        $redirectURL = route('pending-deposit-edit', $deposit->id) . '?' . $parameters;
        return redirect($redirectURL)->with($notification);
    }
}
