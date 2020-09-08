<?php
	
	namespace App\Http\Controllers;
	
	use App\Bond;
	use App\Deposit;
	use App\FiscalYear;
	use App\Helpers\BSDateHelper;
	use App\InvestmentGroup;
	use App\Share;
	use Illuminate\Http\Request;
	use Maatwebsite\Excel\Facades\Excel;
	
	class BimasamitiReportController extends Controller
	{
		public function index()
		{
			
			$currentFiscalyear = BSDateHelper::getCurrentFiscalYear();
			$year = FiscalYear::where('code', '=', $currentFiscalyear)->first();
			$data['fiscal_year_f_id'] = $year->id;
			$first_quarter = array(4, 5, 6);
			$second_quarter = array(7, 8, 9);
			$third_quarter = array(10, 11, 12);
			$fourth_quarter = array(1, 2, 3);
			
			$currentmonth = date('Y-m-d');
			$nepali_date = BSDateHelper::AdToBsEN('-', $currentmonth);
			$nep = explode('-', $nepali_date);
			
			$quarter = null;
			$current_quarter = null;
			switch ($nep[1]) {
				case 1:
				case 2:
				case 3:
					$current_quarter = $fourth_quarter;
					$quarter = 4;
					break;
				case 4:
				case 5:
				case 6:
					$current_quarter = $first_quarter;
					$quarter = 1;
					break;
				case 7:
				case 8:
				case 9:
					$current_quarter = $second_quarter;
					$quarter = 2;
					break;
				case 10:
				case 11:
				case 12:
					$current_quarter = $third_quarter;
					$quarter = 3;
					break;
			}
			
			$data['quarter'] = $quarter;
			
			$quarter_start = $current_quarter[0];
			$quarter_end = $current_quarter[2];

			$data['start_month'] = $this->getNepaliMonth($quarter_start);
			$data['end_month'] = $this->getNepaliMonth($quarter_end);

			/*for ka part*/
			$data['allbonds'] = Bond::where('status', '=', 1)
				->whereMonth('trans_date', '<=', $quarter_end)->get();
			/*->where('fiscal_year_id', '=',$year->id)->whereMonth('trans_date', '>=', $quarter_start)*/
			
			/*for kha part*/
			
			$kha_1 = InvestmentGroup::isKHA_1();
			$kha_2 = InvestmentGroup::isKHA_2();
			$kha_3 = InvestmentGroup::isKHA_3();
			
			$data['kha_1_deposits'] = $this->changekha($kha_1, $year->id, $quarter_start, $quarter_end);

			$data['kha_2_deposits'] = $this->changekha($kha_2, $year->id, $quarter_start, $quarter_end);
			
			$data['kha_3_deposits'] = $this->changekha($kha_3, $year->id, $quarter_start, $quarter_end);
			
			$data['kha_count'] = count($data['kha_1_deposits']) + count($data['kha_2_deposits']) + count($data['kha_3_deposits']);
			
			/*for ga part*/
			$ga_1 = InvestmentGroup::isGA_1();
			$ga_2 = InvestmentGroup::isGA_2();
			$ga_3 = InvestmentGroup::isGA_3();
			$ga_4 = InvestmentGroup::isGA_4();
//			$ga_5 = InvestmentGroup::isGA_5();
			
			$data['ga_1_shares'] = $this->changega($ga_1, $year->id, $quarter_start, $quarter_end);
			
			$data['ga_2_shares'] = $this->changega($ga_2, $year->id, $quarter_start, $quarter_end);
			
			$data['ga_3_shares'] = $this->changega($ga_3, $year->id, $quarter_start, $quarter_end);
			
			$data['ga_4_shares'] = $this->changega($ga_4, $year->id, $quarter_start, $quarter_end);
			
//			$data['ga_5_shares'] = $this->changega($ga_5, $year->id, $quarter_start, $quarter_end);
			
			$data['ga_count'] = count($data['ga_1_shares']) + count($data['ga_2_shares']) + count($data['ga_3_shares'])
				+ count($data['ga_4_shares']) /*+ count($data['ga_5_shares'])*/;
			
			$data['fiscal_years'] = FiscalYear::all();
			$data['grandtotal'] = $data['allbonds']->sum('totalamount') + $data['kha_1_deposits']->sum('deposit_amount') +
                $data['kha_2_deposits']->sum('deposit_amount') + $data['kha_3_deposits']->sum('deposit_amount') +
                $data['ga_1_shares']->sum('total_amount') + $data['ga_2_shares']->sum('total_amount') + $data['ga_2_shares']->sum('total_amount') +
                $data['ga_4_shares']->sum('total_amount') /*+ $data['ga_5_shares']->sum('total_amount')*/;
			return view('report.bimasamiti', $data);
		}
		
		public function changekha($kha_id, $year, $quarter_start, $quarter_end)
		{
			
			$deposits = Deposit::with('institute')->whereIn('status',[1,2,4])->where('invest_group_id','=',$kha_id)->whereMonth('trans_date','<=',$quarter_end)
                ->where('fiscal_year_id','<=',$year)
                ->get();
			return $deposits;
		}
		
		public function changega($ga_id, $year, $quarter_start, $quarter_end)
		{
			$shares = Share::with('institute')->where('status',1)->where('invest_group_id','=',$ga_id)->whereMonth('trans_date','<=',$quarter_end)
                ->where('fiscal_year_id','<=',$year)
                ->get();
			return $shares;
		}
		
		public function filter(Request $request)
		{
			$data = $this->filter0($request);
			return view('report.bimasamiti', $data);
		}
		
		public function filter0(Request $request)
		{
			$input = $request->all();
			$fiscal_id = $input['fiscal_year_id'];
			$quarter = $input['months'];
			$data['fiscal_year_f_id'] = $fiscal_id;
			
			if ($quarter == 1) { //sharwan to asoj
				$quarter_start = 4;
				$quarter_end = 6;
			} elseif ($quarter == 2) { //kartik to poush
				$quarter_start = 7;
				$quarter_end = 9;
			} elseif ($quarter == 3) { //magh to chaitra
				$quarter_start = 10;
				$quarter_end = 12;
			} else {                //baishak to asar
				$quarter_start = 1;
				$quarter_end = 3;
			}
			/*for ka part*/
			
			$data['quarter_start'] = $quarter_start;
			$data['start_month'] = $this->getNepaliMonth($quarter_start);
			$data['quarter_end'] = $quarter_end;
			$data['end_month'] = $this->getNepaliMonth($quarter_end);
			
			if ($fiscal_id != null || $quarter != null) {
			    $numbers = array([1,2]);
				$allbonds = $allbonds = Bond::with('institute')->whereIn('status',$numbers)->where('fiscal_year_id', '<=', $fiscal_id)
//					->whereMonth('trans_date', '>', $quarter_start)
					->whereMonth('trans_date', '<=', $quarter_end)->get();
			} else {
				$allbonds = Bond::whereIn('status', '=', [1,2])->get();
			}
			$data['allbonds'] = $allbonds;
			
//			dd($allbonds);
			/*for kha part*/
			
			$kha_1 = InvestmentGroup::isKHA_1();
			$kha_2 = InvestmentGroup::isKHA_2();
			$kha_3 = InvestmentGroup::isKHA_3();
			
			$data['kha_1_deposits'] = $this->changekha($kha_1, $fiscal_id, $quarter_start, $quarter_end);
			
			$data['kha_2_deposits'] = $this->changekha($kha_2, $fiscal_id, $quarter_start, $quarter_end);
			
			$data['kha_3_deposits'] = $this->changekha($kha_3, $fiscal_id, $quarter_start, $quarter_end);
			
			$data['kha_count'] = count($data['kha_1_deposits']) + count($data['kha_2_deposits']) + count($data['kha_3_deposits']);
			
			/*for ga part*/
			$ga_1 = InvestmentGroup::isGA_1();
			$ga_2 = InvestmentGroup::isGA_2();
			$ga_3 = InvestmentGroup::isGA_3();
			$ga_4 = InvestmentGroup::isGA_4();
			$ga_5 = InvestmentGroup::isGA_5();
			
			$data['ga_1_shares'] = $this->changega($ga_1, $fiscal_id, $quarter_start, $quarter_end);
			
			$data['ga_2_shares'] = $this->changega($ga_2, $fiscal_id, $quarter_start, $quarter_end);
			
			$data['ga_3_shares'] = $this->changega($ga_3, $fiscal_id, $quarter_start, $quarter_end);
			
			$data['ga_4_shares'] = $this->changega($ga_4, $fiscal_id, $quarter_start, $quarter_end);
			
			$data['ga_5_shares'] = $this->changega($ga_5, $fiscal_id, $quarter_start, $quarter_end);
			
			$data['ga_count'] = count($data['ga_1_shares']) + count($data['ga_2_shares']) + count($data['ga_3_shares']) +
				count($data['ga_4_shares']) + count($data['ga_5_shares']);
			
			$data['fiscal_years'] = FiscalYear::all();
			$data['quarter'] = $quarter;

            $data['grandtotal'] = $data['allbonds']->sum('totalamount') + $data['kha_1_deposits']->sum('deposit_amount') +
                $data['kha_2_deposits']->sum('deposit_amount') + $data['kha_3_deposits']->sum('deposit_amount') +
                $data['ga_1_shares']->sum('total_amount') + $data['ga_2_shares']->sum('total_amount') + $data['ga_2_shares']->sum('total_amount') +
                $data['ga_4_shares']->sum('total_amount') + $data['ga_5_shares']->sum('total_amount');

			return $data;
		}
		
		public function excel(Request $request)
		{
			$data = $this->filter0($request);
			
			return Excel::create('bimasamiti-report', function ($excel) use ($data) {
				$excel->sheet('mySheet', function ($sheet) use ($data) {
					$sheet->mergeCells('A2:G2');
					$sheet->meregCells('A3:G3');
					$fiscal = FiscalYear::findOrFail($data['fiscal_year_f_id'])->first();
					$fiscal_year = 'आ.व ' . $fiscal->code;
					
					
					$sheet->cell('A2', function ($cell) use ($fiscal_year) {
						$cell->setValue($fiscal_year)->setFontWeight('bold')->setFontSize(15)->setAlignment('center');
					});
					
					/*$sheet->cell('A1', function ($cell) {
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
						$cell->setValue('Duration (days)')->setFontWeight('bold');
					});
					$sheet->cell('F1', function ($cell) {
						$cell->setValue('Mature Days')->setFontWeight('bold');
					});
					$sheet->cell('G1', function ($cell) {
						$cell->setValue('Rate per Unit')->setFontWeight('bold');
					});
					$sheet->cell('H1', function ($cell) {
						$cell->setValue('Total Unit')->setFontWeight('bold');
					});
					$sheet->cell('I1', function ($cell) {
						$cell->setValue('Total Amount')->setFontWeight('bold');
					});
					$sheet->cell('J1', function ($cell) {
						$cell->setValue('Details')->setFontWeight('bold');
					});
					$sheet->cell('K1', function ($cell) {
						$cell->setValue('Interest Rate')->setFontWeight('bold');
					});
					$sheet->cell('L1', function ($cell) {
						$cell->setValue('Estimated Earning')->setFontWeight('bold');
					});
					$sheet->cell('M1', function ($cell) {
						$cell->setValue('Alert Days')->setFontWeight('bold');
					});
					
					if (!empty($data)) {
						$i = 1;
						$total = 0;
						foreach ($data as $value) {
							$i = $i+1;
							$sheet->setBorder('A' . $i . ':M' . $i, 'thin');
							$total += $value->totalamount;
							$sheet->cell('A' . $i, $value->fiscalyear->code);
							$sheet->cell('B' . $i, $value->trans_date);
							$sheet->cell('C' . $i, $value->institute->institution_name);
							$sheet->cell('D' . $i, $value->bond_type->name);
							$sheet->cell('E' . $i, $value->days);
							$sheet->cell('F' . $i, $value->mature_date);
							$sheet->cell('G' . $i, $value->rateperunit);
							$sheet->cell('H' . $i, $value->totalunit);
							$sheet->cell('I' . $i, $value->totalamount);
							$sheet->cell('J' . $i, $value->unitdetails);
							$sheet->cell('K' . $i, $value->interest_rate);
							$sheet->cell('L' . $i, $value->estimated_earning);
							$sheet->cell('M' . $i, $value->alert_days);
						}
						$to = $i + 1;
						$sheet->cell('H'.$to, function ($cell){
							$cell->setValue('Total Amount')->setFontWeight('bold');
						});
						$sheet->cell('I' . $to, $total);
					}*/
				});
			})->download('xlsx');
		}
		
		public function getNepaliMonth($number)
		{
			switch ($number) {
				case 1:
					$n_month = "बैशाख";
					break;
				case 2:
					$n_month = "जेष्ठ";
					break;
				case 3:
					$n_month = "असार";
					break;
				case 4:
					$n_month = "श्रावण";
					break;
				case 5:
					$n_month = "भाद्र";
					break;
				case 6:
					$n_month = "आश्विन";
					break;
				case 7:
					$n_month = "कार्तिक";
					break;
				case 8:
					$n_month = "मंसिर";
					break;
				case 9:
					$n_month = "पुष";
					break;
				case 10:
					$n_month = "माघ";
					break;
				case 11:
					$n_month = "फाल्गुन";
					break;
				case 12:
					$n_month = "चैत्र";
					break;
			}
			return $n_month;
		}
	}
