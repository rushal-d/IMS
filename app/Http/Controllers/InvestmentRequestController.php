<?php

namespace App\Http\Controllers;

use App\BankBranch;
use App\Deposit;
use App\InvestmentInstitution;
use App\InvestmentRequest;
use App\InvestmentRequestDocument;
use App\OrganizationBranch;
use App\Staff;
use App\UploadedDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;

class InvestmentRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['i'] = 1;
        if (!empty($request->page)) {
            $data['i'] = ($request->page - 1) * 20 + 1;
        }
        $investment_requests = new InvestmentRequest();
        if (!empty($request->from_date_en)) {
            $investment_requests = $investment_requests->where('request_date_en', '>=', $request->from_date_en);
        }

        if (!empty($request->to_date_en)) {
            $investment_requests = $investment_requests->where('request_date_en', '<=', $request->to_date_en);
        }

        if (!empty($request->organization_branch_id)) {
            $investment_requests = $investment_requests->where('organization_branch_id', '=', $request->organization_branch_id);
        }

        if (!empty($request->institution_id)) {
            $investment_requests = $investment_requests->where('institution_id', '=', $request->institution_id);
        }
        $data['investment_requests'] = $investment_requests->latest()->paginate(20);
        $data['organization_branches'] = OrganizationBranch::pluck('branch_name', 'id');
        $data['investment_institutions'] = InvestmentInstitution::where('invest_type_id', 2)->pluck('institution_name', 'id');
        $data['investment_request_status'] = Config::get('constants.investment_request_status');

        return view('investmentrequest.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['organization_branches'] = OrganizationBranch::pluck('branch_name', 'id');
        $data['investment_institutions'] = InvestmentInstitution::where('invest_type_id', 2)->pluck('institution_name', 'id');
        $data['investment_payment_methods'] = Config::get('constants.investment_payment_methods');
        $data['investment_request_status'] = Config::get('constants.investment_request_status');
        $data['bank_branches'] = BankBranch::pluck('branch_name', 'id');
        $data['staffs'] = Staff::pluck('name', 'id');
        return view('investmentrequest.create', $data);
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
        $input['created_by_id'] = Auth::id();
        $investmentRequest = InvestmentRequest::create($input);
        if (isset($input['docs']) && count($input['docs']) > 0) {
            foreach ($input['docs'] as $docs) {
                $investmentRequestDocs = new InvestmentRequestDocument();
                $investmentRequestDocs->investment_request_id = $investmentRequest->id;
                $investmentRequestDocs->name = $docs;
                $investmentRequestDocs->save();
            }
        }
        $notification = array(
            'message' => 'Data Added Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('investment-request.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\InvestmentRequest $investmentRequest
     * @return \Illuminate\Http\Response
     */
    public function show(InvestmentRequest $investmentRequest)
    {
        $data['investmentRequest'] = $investmentRequest;
        $data['investment_payment_methods'] = Config::get('constants.investment_payment_methods');
        $data['investment_request_status'] = Config::get('constants.investment_request_status');
        return view('investmentrequest.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\InvestmentRequest $investmentRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(InvestmentRequest $investmentRequest)
    {
        $data['investmentRequest'] = $investmentRequest;
        $data['organization_branches'] = OrganizationBranch::pluck('branch_name', 'id');
        $data['investment_institutions'] = InvestmentInstitution::where('invest_type_id', 2)->pluck('institution_name', 'id');
        $data['investment_payment_methods'] = Config::get('constants.investment_payment_methods');
        $data['investment_request_status'] = Config::get('constants.investment_request_status');
        $data['bank_branches'] = BankBranch::pluck('branch_name', 'id');
        $data['staffs'] = Staff::pluck('name', 'id');
        return view('investmentrequest.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\InvestmentRequest $investmentRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvestmentRequest $investmentRequest)
    {
        $input = $request->all();
        $input['updated_by_id'] = Auth::id();
        $investmentRequest->update($input);
        InvestmentRequestDocument::where('investment_request_id', $investmentRequest->id)->delete();
        if (isset($input['docs']) && count($input['docs']) > 0) {
            foreach ($input['docs'] as $docs) {
                $investmentRequestDocs = new InvestmentRequestDocument();
                $investmentRequestDocs->investment_request_id = $investmentRequest->id;
                $investmentRequestDocs->name = $docs;
                $investmentRequestDocs->save();
            }
        }
        $notification = array(
            'message' => 'Data Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\InvestmentRequest $investmentRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvestmentRequest $investmentRequest)
    {
        $status_mesg = $investmentRequest->delete();
        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Deleted Successfully' : 'Error Occured! Try Again!';
        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('investment-request.index')->with($notification);
    }

    public function transferToDeposits($id, Request $request)
    {
        $investmentRequest = InvestmentRequest::find($id);
        $investmentRequest->status = 2;
        $investmentRequest->save();
        $input = $investmentRequest->toArray();
        $input['is_pending'] = 1;
        $input['notes'] = $input['remarks'];
        $input['investment_request_id'] = $investmentRequest->id;

        unset($input['created_at']);
        unset($input['updated_at']);
        $deposit = Deposit::create($input);

        if ($investmentRequest->documents->count() > 0) {
            foreach ($investmentRequest->documents as $document) {
                $depositDocument = new UploadedDocument();
                $depositDocument->deposit_id = $deposit->id;
                $depositDocument->name = $document->name;
                $depositDocument->save();
            }
        }
        if($request->is_ajax){
            return response()->json([
                'status' => true,
            ]);
        }
        return redirect()->route('deposit.edit', $deposit->id);
    }

    public function downloadExcel(Request $request)
    {
        $data['i'] = 1;
        if (!empty($request->page)) {
            $data['i'] = ($request->page - 1) * 20 + 1;
        }
        $investment_requests =  InvestmentRequest::all();
        if (!empty($request->from_date_en)) {
            $investment_requests = $investment_requests->where('request_date_en', '>=', $request->from_date_en);
        }

        if (!empty($request->to_date_en)) {
            $investment_requests = $investment_requests->where('request_date_en', '<=', $request->to_date_en);
        }

        if (!empty($request->organization_branch_id)) {
            $investment_requests = $investment_requests->where('organization_branch_id', '=', $request->organization_branch_id);
        }

        if (!empty($request->institution_id)) {
            $investment_requests = $investment_requests->where('institution_id', '=', $request->institution_id);
        }

        $data = $investment_requests;
        return Excel::create('Investment Request'.date('Y-m-d H:i'), function ($excel) use ($data){
            $excel->sheet('Investment Requests', function ($sheet) use ($data) {
                $sheet->cell('A1', function ($cell) {
                    $cell->setValue('Date (AD)')->setFontWeight('bold');
                });
                $sheet->cell('B1', function ($cell) {
                    $cell->setValue('Date (BS)')->setFontWeight('bold');
                });
                $sheet->cell('C1', function ($cell) {
                    $cell->setValue('Bank')->setFontWeight('bold');
                });
                $sheet->cell('D1', function ($cell) {
                    $cell->setValue('Bank Branch')->setFontWeight('bold');
                });
                $sheet->cell('E1', function ($cell) {
                    $cell->setValue('Days')->setFontWeight('bold');
                });
                $sheet->cell('F1', function ($cell) {
                    $cell->setValue('Interest Payment Method')->setFontWeight('bold');
                });
                $sheet->cell('G1', function ($cell) {
                    $cell->setValue('Organization Branch')->setFontWeight('bold');
                });
                $sheet->cell('H1', function ($cell) {
                    $cell->setValue('Staff')->setFontWeight('bold');
                });
                $sheet->cell('I1', function ($cell) {
                    $cell->setValue('Amount')->setFontWeight('bold');
                });
                $sheet->cell('J1', function ($cell) {
                    $cell->setValue('Interest Rate')->setFontWeight('bold');
                });
                $sheet->cell('K1', function ($cell) {
                    $cell->setValue('Status')->setFontWeight('bold');
                });
                $sheet->cell('L1', function ($cell) {
                    $cell->setValue('Note')->setFontWeight('bold');
                });

                if (!empty($data)) {
                    $i = 1;
                    foreach ($data as $value) {
                        $i = $i + 1;
                        $sheet->setBorder('A' . $i . ':L' . $i, 'thin');
                        $sheet->cell('A' . $i, $value->request_date_en);
                        $sheet->cell('B' . $i, $value->request_date);
                        $sheet->cell('C' . $i, $value->institution->institution_name);
                        $sheet->cell('D' . $i, $value->branch->branch_name);
                        $sheet->cell('E' . $i, $value->days);
                        $sheet->cell('F' . $i, Config::get('constants.investment_payment_methods')[$value->interest_payment_method]);
                        $sheet->cell('G' . $i, $value->organization_branch->branch_name);
                        $sheet->cell('H' . $i, $value->staff->name);
                        $sheet->cell('I' . $i, $value->deposit_amount);
                        $sheet->cell('J' . $i, $value->interest_rate);
                        $sheet->cell('K' . $i, Config::get('constants.investment_request_status')[$value->status]);
                        $sheet->cell('L' . $i, $value->remarks);
                    }
                }
            });
        })->download('xlsx');
    }

    public function ajaxUpdate(Request $request){
        $request_status  =  InvestmentRequest::find($request->id);
        $request_status->status = $request->request_status;
        $request_status->save();

//        $mesg = ($request_status) ? 'Deleted Successfully' : 'Error Occured! Try Again!';
//        $notification = array(
//            'message' => $mesg,
//        );
    }
}
