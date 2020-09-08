<?php

namespace App\Http\Controllers;

use App\Bond;
use App\FiscalYear;
use App\Helpers\BSDateHelper;
use App\InvestmentInstitution;
use App\InvestmentType;
use App\OrganizationBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;

class BondController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $bonds = Bond::query();

        if (!empty($request->fiscal_year_id) && empty($request->start_date_en)) {
            $selectedFiscalYear = FiscalYear::find($request->fiscal_year_id);
            if (!empty($selectedFiscalYear)) {
                $bonds = $bonds->where(function ($query) use ($selectedFiscalYear) {
                    $query->where([['trans_date_en', '>=', $selectedFiscalYear->start_date_en], ['mature_date_en', '<=', $selectedFiscalYear->end_date_en]]);
                    $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->start_date_en], ['mature_date_en', '>=', $selectedFiscalYear->start_date_en]]);
                    $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->end_date_en], ['mature_date_en', '>=', $selectedFiscalYear->end_date_en]]);
                    $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->start_date_en], ['mature_date_en', '>=', $selectedFiscalYear->end_date_en]]);
                });
            }
        }
        if (!empty($request->institution_id)) {
            $bonds = $bonds->where('institution_id', $input['institution_id']);

        }
        if (!empty($request->investment_subtype_id)) {
            $bonds = $bonds->where('investment_subtype_id', $input['investment_subtype_id']);
        }

        if (!empty($request->status)) {
            $bonds = $bonds->where('status', $input['status']);
        }
        if (!empty($input['start_date_en'])) {
            $start_date_en = $input['start_date_en'];
            $end_date_en = date('Y-m-d');
            if (!empty($input['end_date_en'])) {
                $end_date_en = $input['end_date_en'];
            }
            $bonds = $bonds->where(function ($query) use ($start_date_en, $end_date_en) {
                $query->where([['trans_date_en', '>=', $start_date_en], ['mature_date_en', '<=', $end_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $start_date_en], ['mature_date_en', '>=', $start_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $end_date_en], ['mature_date_en', '>=', $end_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $start_date_en], ['mature_date_en', '>=', $end_date_en]]);
            });
        }
        $bond_total_collection = clone($bonds);
        $bonds = $bonds->with('fiscalyear','institute')->latest()->paginate(50);

        $data['bondtotalamount'] = $bond_total_collection->where('status', '<>', 3)->sum('totalamount');
        $data['bondestimated_earning'] = $bond_total_collection->where('status', '<>', 3)->sum('estimated_earning');
        $bond_id = InvestmentType::InvestmenttypeBond();
        $data['fiscal_years'] = FiscalYear::pluck('code', 'id');
        $investment = InvestmentType::findOrFail($bond_id);
        $data['institutes'] = $investment->invest_inst->pluck('institution_name', 'id');
        $data['bond_statuses'] = Config::get('constants.bond_status');
        $data['investment_subtypes'] = $investment->investment_subtype;

        return view('bond.index', $data, compact('bonds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bond_id = InvestmentType::InvestmenttypeBond();
        $data['fiscal_years'] = FiscalYear::all();
        $investment = InvestmentType::findOrFail($bond_id);
        $data['institutes'] = $investment->invest_inst->sortBy('institution_name');
        $data['investment_subtypes'] = $investment->investment_subtype;
//        dd($data['institutes'], $data['investment_subtypes']);
        $data['organization_branch'] = OrganizationBranch::pluck('branch_name', 'id');
        $data['receipt_location'] = Config::get('constants.receipt_location');
        $data['interest_payment_method'] = Config::get('constants.investment_payment_methods');
        return view('bond.create', $data);

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
        $input['invest_group_id'] = InvestmentInstitution::findOrFail($input['institution_id'])->invest_group_id;
        $input['investment_subtype_id'] = InvestmentInstitution::findOrFail($input['institution_id'])->invest_subtype_id;
        if (!empty($input['trans_date_en'])) {
            $fiscalyear = FiscalYear::whereDate('start_date_en', '<=', $input['trans_date_en'])->whereDate('end_date_en', '>=', $input['trans_date_en'])->latest()->first();
            if (!empty($fiscalyear)) {
                $input['fiscal_year_id'] = $fiscalyear->id;
            }
        }
        $bond = Bond::create($input);
        $status_mesg = $this->updatestatus($bond);
        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data added successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('bond.index')->with($notification);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Bond $bond
     * @return \Illuminate\Http\Response
     */
    public function show(Bond $bond)
    {
        return view('bond.show', compact('bond'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Bond $bond
     * @return \Illuminate\Http\Response
     */
    public function edit(Bond $bond)
    {
        $bond_id = InvestmentType::InvestmenttypeBond();
        $data['fiscal_years'] = FiscalYear::all();
        $investment = InvestmentType::findOrFail($bond_id);
        $data['institutes'] = $investment->invest_inst;
        $data['investment_subtypes'] = $investment->investment_subtype;
        $data['interest_payment_method'] = Config::get('constants.investment_payment_methods');
        $data['receipt_location'] = Config::get('constants.receipt_location');
        $data['organization_branch'] = OrganizationBranch::pluck('branch_name', 'id');
//        dd($data['investment_subtypes']);
        return view('bond.edit', $data, compact('bond'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Bond $bond
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bond $bond)
    {
        $input = $request->all();
        $user_id = Auth::user()->id;
        $input['updated_by_id'] = $user_id;
        $input['invest_group_id'] = InvestmentInstitution::findOrFail($input['institution_id'])->invest_group_id;
        $input['investment_subtype_id'] = InvestmentInstitution::findOrFail($input['institution_id'])->invest_subtype_id;
        if (!empty($input['trans_date_en'])) {
            $fiscalyear = FiscalYear::whereDate('start_date_en', '<=', $input['trans_date_en'])->whereDate('end_date_en', '>=', $input['trans_date_en'])->latest()->first();
            if (!empty($fiscalyear)) {
                $input['fiscal_year_id'] = $fiscalyear->id;
            }
        }
        $bond->update($input);

        $status_mesg = $this->updatestatus($bond);

        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data updated Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('bond.index')->with($notification);

    }

    /*common function to be called when adding and updating bond*/
    public function updatestatus($bond)
    {
        $today_date = date('Y-m-d');
        $bondstatus = 1;
        $mature_date = strtotime($bond->mature_date_en);
        $today = strtotime($today_date); //time to check alert days with today's date
        $datediff = $mature_date - $today;
        $expire_days = (int)floor(($datediff / (60 * 60 * 24)));
        $bond->expiry_days = $expire_days;
        if ($expire_days <= 0) {
            $bondstatus = 3;
        }
        if ($expire_days <= $bond->alert_days and $expire_days > 0) {
            $bondstatus = 2;
        }
        $bond->status = $bondstatus;
        $status_mesg = $bond->save();
        return $status_mesg;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Bond $bond
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bond $bond)
    {
        $bond->deleted_by_id = Auth::user()->id;
        $bond->save();
        $status_mesg = $bond->delete();

        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Deleted Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('bond.index')->with($notification);
    }

    public function adddays(Request $request)
    {
        $input = $request->all();
        $date = $input['date'];
        $days = $input['days'] - 1;

        $engdate = BSDateHelper::BsToAd('-', $date);
        $added_date = date('Y-m-d', strtotime($engdate . ' + ' . $days . ' days'));
        $nepalidate_mature = BSDateHelper::AdToBsEN('-', $added_date);

        $data = array();
        $data['mature_date_en'] = $added_date;
        $data['mature_date'] = $nepalidate_mature;
        return response()->json($data);

    }


    public function downloadExcel(Request $request)
    {
        $input = $request->all();
        $bonds = Bond::query();

        if (!empty($request->fiscal_year_id) && empty($request->start_date_en)) {
            $selectedFiscalYear = FiscalYear::find($request->fiscal_year_id);
            if (!empty($selectedFiscalYear)) {
                $bonds = $bonds->where(function ($query) use ($selectedFiscalYear) {
                    $query->where([['trans_date_en', '>=', $selectedFiscalYear->start_date_en], ['mature_date_en', '<=', $selectedFiscalYear->end_date_en]]);
                    $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->start_date_en], ['mature_date_en', '>=', $selectedFiscalYear->start_date_en]]);
                    $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->end_date_en], ['mature_date_en', '>=', $selectedFiscalYear->end_date_en]]);
                    $query->orWhere([['trans_date_en', '<=', $selectedFiscalYear->start_date_en], ['mature_date_en', '>=', $selectedFiscalYear->end_date_en]]);
                });
            }
        }
        if (!empty($request->institution_id)) {
            $bonds = $bonds->where('institution_id', $input['institution_id']);

        }
        if (!empty($request->investment_subtype_id)) {
            $bonds = $bonds->where('investment_subtype_id', $input['investment_subtype_id']);
        }

        if (!empty($request->status)) {
            $bonds = $bonds->where('status', $input['status']);
        }
        if (!empty($input['start_date_en'])) {
            $start_date_en = $input['start_date_en'];
            $end_date_en = date('Y-m-d');
            if (!empty($input['end_date_en'])) {
                $end_date_en = $input['end_date_en'];
            }
            $bonds = $bonds->where(function ($query) use ($start_date_en, $end_date_en) {
                $query->where([['trans_date_en', '>=', $start_date_en], ['mature_date_en', '<=', $end_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $start_date_en], ['mature_date_en', '>=', $start_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $end_date_en], ['mature_date_en', '>=', $end_date_en]]);
                $query->orWhere([['trans_date_en', '<=', $start_date_en], ['mature_date_en', '>=', $end_date_en]]);
            });
        }
        $bonds = $bonds->get();
        $data = $bonds;
        return Excel::create('Bond', function ($excel) use ($data) {
            $excel->sheet('Sheet 1', function ($sheet) use ($data) {
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
                        $i = $i + 1;
                        $sheet->setBorder('A' . $i . ':M' . $i, 'thin');
                        if ($value->status != 3) {
                            $total += $value->totalamount;
                        }
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
                    $sheet->cell('H' . $to, function ($cell) {
                        $cell->setValue('Total Amount')->setFontWeight('bold');
                    });
                    $sheet->cell('I' . $to, $total);
                }
            });
        })->download('xlsx');
    }
}
