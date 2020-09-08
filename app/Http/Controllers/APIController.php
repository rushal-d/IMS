<?php

namespace App\Http\Controllers;

use App\APILog;
use App\Deposit;
use App\FiscalYear;
use App\Helpers\BSDateHelper;
use App\InvestmentInstitution;
use App\OrganizationBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class APIController extends Controller
{
    /** Log API data with status
     * @param $data
     * @param $status
     */
    public function logData($data, $status){
        APILog::create(['data' => json_encode($data), 'status' => $status]);
    }

    public function deposit_store(Request $request)
    {
    	$val = $request->getContent();
    	$data = [];
    	if(!empty($val)){ //checking is from api of premier
		    parse_str(str_replace('"', '', $val),$data);
	    }
	    else{
    		$data = $request->all();
	    }
		//DEBUGGING CODE
/*
		ob_start();
	    var_dump($data);
	    file_put_contents('apitest.txt', ob_get_flush());*/
	    $validator = \Validator::make($data, [
	    'cheque_date' => 'required|date_format:Y-m-d',
	    'credit_date' => 'required|date_format:Y-m-d',
	    'deposit_amount' => 'required|numeric'],

            [
	            'cheque_date' => 'Please send valid cheque date format (YYYY-mm-dd)',
	            'credit_date.date' => 'Please send valid credit date format (YYYY-mm-dd)',
	            'deposit_amount.numeric' => 'Invalid Deposit Amount',
            ]
        );

        if ($validator->fails()) {
            $response_code = 101;
            $this->logData($data, $response_code);
	        return response()->json(['status' => false, 'response_code' => $response_code, 'message' => implode(",",$validator->messages()->all())]);
        } else {
            $input = $data;
            if (!empty($input['cheque_date'])) {
                $input['cheque_date_np'] = BSDateHelper::AdToBsEN('-', date('Y-m-d', strtotime($input['cheque_date'])));
            }
            $fiscal_year = null;
            if (!empty($input['credit_date'])) {
                $input['credit_date_np'] = BSDateHelper::AdToBsEN('-', date('Y-m-d', strtotime($input['credit_date'])));

                $fiscal_year = FiscalYear::whereDate('start_date_en', '<=', $input['credit_date'])->whereDate('end_date_en', '>=', $input['credit_date'])->first();
                if (!empty($fiscal_year)) {
                    $input['fiscal_year_id'] = $fiscal_year->id;
                }
            }
            if (!empty($input['bank_code'])) {
                $deposit_institution = InvestmentInstitution::where('invest_type_id', 2)->where('institution_code', $input['bank_code'])->first();
                if (!empty($deposit_institution)) {
                    $input['institution_id'] = $deposit_institution->id;
                    $input['invest_group_id'] = $deposit_institution->invest_group_id;
                    $input['investment_subtype_id'] = $deposit_institution->invest_subtype_id;
                }
            }
            if (!empty($input['organization_branch'])) { //in iensure, they are sending the org branch id, we are mapping it to branch code
                $organization_branch = OrganizationBranch::where('branch_code', (int) $input['organization_branch'])->first();
                //check if organization branch exists else create a new branch
                if (empty($organization_branch)) {
                    $organization_branch = new OrganizationBranch();
                    $organization_branch->branch_code = $input['organization_branch'];
                    $organization_branch->save();
                }
                $input['organization_branch_id'] = $organization_branch->id;
            }/**/
            $input['is_pending'] = 1;
            $deposit = null;
            if (!empty($input['voucher_number']) && !empty($fiscal_year) && !empty($input['organization_branch'])) {
                $deposit = Deposit::withoutGlobalScope('is_pending')->where('voucher_number', $input['voucher_number'])
	                                                    ->where('organization_branch_id', $input['organization_branch_id'])
                                                         ->where('fiscal_year_id', $fiscal_year->id)->first();
            }
            if (empty($deposit)) {
                $save = Deposit::create($input);
                if($save){
                    $response_code = 100;
                    $this->logData($data, $response_code);
	                return response()->json(['status' => true, 'response_code' => $response_code, 'message' => 'Deposit Saved Successfully']);
                }
                else{
                    $response_code = 105;
                    $this->logData($data, $response_code);
	                return response()->json(['status' => false, 'response_code' => $response_code, 'message' => 'System Error. Error Occurred while Saving New Deposit']);
                }
            } else {
	            if($deposit->is_pending == 0){ //don't update if same record is not in pending list
                    $response_code = 102;
                    $this->logData($data, $response_code);
	                return response()->json(['status' => false, 'response_code' => $response_code, 'message' => 'Deposit Already on Active List']);
	            }
	            else{
		            $update = $deposit->update($input);
		            if($update){
                        $response_code = 104;
                        $this->logData($data, $response_code);
			            return response()->json(['status' => true, 'response_code' => $response_code, 'message' => 'Deposit Updated Successfully']);
		            }
		            else{
                        $response_code = 106;
                        $this->logData($data, $response_code);
			            return response()->json(['status' => false, 'response_code' => $response_code, 'message' => 'System Error. Error Occurred while Updating Deposit']);
		            }
		        }

            }
        } //if other any case
        $response_code = 103;
        $this->logData($data, $response_code);
	    return response()->json(['status' => false, 'response_code' => $response_code, 'message' => 'System Error']);

    }
}
