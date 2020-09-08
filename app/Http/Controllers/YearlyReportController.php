<?php

namespace App\Http\Controllers;

use App\Bond;
use App\Deposit;
use App\FiscalYear;
use App\Helpers\BSDateHelper;
use App\InvestmentGroup;
use App\Share;
use Illuminate\Http\Request;

class YearlyReportController extends Controller
{
	public function index(Request $request){
		if(!empty($request->all())){
			$year_id = $request->input('fiscal_year_id');
			$year = FiscalYear::findOrFail($year_id);
		}else{
			$currentFiscalyear = BSDateHelper::getCurrentFiscalYear();
			$year = FiscalYear::where('code','=', $currentFiscalyear)->first();
		}
		$data['fiscal_year_now'] = $year;
		$data['fiscal_year_now_id'] = $year->id;
		$fiscal_id = $year->id;
		$data['fiscal_years'] = FiscalYear::all();
		
		$kha_1 = InvestmentGroup::isKHA_1();
		$kha_2 = InvestmentGroup::isKHA_2();
		$kha_3 = InvestmentGroup::isKHA_3();
		
		$ga_1 = InvestmentGroup::isGA_1();
		$ga_2 = InvestmentGroup::isGA_2();
		$ga_3 = InvestmentGroup::isGA_3();
		$ga_4 = InvestmentGroup::isGA_4();
		$ga_5 = InvestmentGroup::isGA_4();
		
		$bonds = Bond::where('status','=',1)->where('fiscal_year_id','=', $year->id)->sum('totalamount');
		$data['bonds'] = $bonds;
		$ga_1_shares = $this->changega($ga_1,$fiscal_id);
		$data['ga_1_shares'] =  $ga_1_shares;
		$ga_5_shares = $this->changega($ga_5,$fiscal_id);
		$data['ga_5_shares'] = $ga_5_shares;
		
//		if($bonds != null || $ga_1_shares != null || $ga_5_shares != null) {
			$total_one = $bonds + $ga_1_shares + $ga_5_shares;
//		}
		
		$data['total_one'] = $total_one;
		
		$kha_1_deposits = $this->changekha($kha_1,$fiscal_id);
		$data['kha_1_deposits'] = $kha_1_deposits;
		$kha_2_deposits = $this->changekha($kha_2,$fiscal_id);
		$data['kha_2_deposits'] = $kha_2_deposits;
		$kha_3_deposits = $this->changekha($kha_3,$fiscal_id);
		$data['kha_3_deposits'] = $kha_3_deposits;
		$ga_2_shares = $this->changega($ga_2,$fiscal_id);
		$data['ga_2_shares'] = $ga_2_shares;
		
		$total_two = $kha_1_deposits + $kha_2_deposits + $kha_3_deposits + $ga_5_shares;
		$data['total_two'] = $total_two;
		
		$data['grand_total'] = $total_one + $total_two;
		return view('report.yearlyreport', $data);
	}
	
	public function changekha($kha_id,$year)
	{
		
		$all_khas = array();
		$deposits = Deposit::with('institute')->get();
		foreach ($deposits as $deposit) {
			$case = ($deposit->institute->invest_group_id == $kha_id) ? true : false;
			if ($case) {
				array_push($all_khas, $deposit->id);
			}
		}
		
		if (!empty($all_khas)) {
			$all_khas = $deposits->whereIn('id',$all_khas)->where('status','=',1)
				->where('fiscal_year_id', '=', $year)->sum('deposit_amount');
		}
		
		if(empty($all_khas)){
			$all_khas = 0;
		}
		return $all_khas;
	}
	
	public function changega($ga_id,$year){
		$all_gas = array();
		$shares = Share::with('instituteByCode')->get();
		foreach ($shares as $share){
		    if(empty($share->instituteByCode))
            {
                dd($share);
            }
			$case1 = ($share->instituteByCode->invest_group_id == $ga_id) ? true : false;
			if($case1){
				array_push($all_gas, $share->id);
			}
		}
		if(!empty($all_gas)) {
			$all_gas = $shares->whereIn('id',$all_gas)->where('status','=',1)
				->where('fiscal_year_id', '=', $year)->sum('total_amount');
		}
		if(empty($all_gas)){
			$all_gas = 0;
		}
		return $all_gas;
	}
}
