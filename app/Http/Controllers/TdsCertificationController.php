<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\FiscalYear;
use App\InvestmentType;
use App\TdsCertificationLetter;
use App\User;
use App\UserOrganization;
use Illuminate\Http\Request;

class TdsCertificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $deposit = Deposit::where('id', 99999999999);
        $deposit_id = InvestmentType::InvestmenttypeDeposit();
        $fiscal_years = FiscalYear::all();
        $investment = InvestmentType::findOrFail($deposit_id);
        $institutes = $investment->invest_inst->sortBy('institution_name');
        $tds = TdsCertificationLetter::query();

        return view('deposit.tdscertification', ['fiscal_years' => $fiscal_years, 'institutes' => $institutes, 'tds' => $tds]);
    }

    public function searchTds(Request $request)
    {
        $deposit_id = InvestmentType::InvestmenttypeDeposit();
        $fiscal_years = FiscalYear::all();
        $investment = InvestmentType::findOrFail($deposit_id);
        $institutes = $investment->invest_inst->sortBy('institution_name');
        $deposit = Deposit::query();


        if(!empty($request->fiscal_year_id))
        {
            $deposit = $deposit->where('fiscal_year_id', $request->fiscal_year_id);
        }
        if(!empty($request->institution_id))
        {
            $deposit = $deposit->where('institution_id', $request->institution_id);
        }
        $deposit = $deposit->get();
        $letter_tds = UserOrganization::all();
        if($letter_tds->isEmpty()){
            $letter_tds = "";
        }else{
            $letter_tds = $letter_tds->first()->tds_certification_letter;
        }
        if($deposit->isNotEmpty() || $deposit->isNotEmpty()){
            $previous = TdsCertificationLetter::where('institution_id', '=', $deposit->first()->institution_id)->where('fiscal_year_id', '=', $deposit->first()->fiscal_year_id)->first();
            $previous_exists = TdsCertificationLetter::where('institution_id', '=', $deposit->first()->institution_id)->where('fiscal_year_id', '=', $deposit->first()->fiscal_year_id)->exists();
        }else{
            $previous = "";
            $previous_exists = "";
        }
        return view('deposit.searchtds', ['fiscal_years' => $fiscal_years, 'institutes' => $institutes, 'deposit' => $deposit, 'previous_exists' => $previous_exists, 'previous' => $previous, 'letter_tds' => $letter_tds]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fiscal_year_id = $request->fiscal_year_id;
//        dd($fiscal_year_id);
        $institution_id = $request->institution_id;

        $tds = new TdsCertificationLetter();
        $tds->content = $request->okay;
        $tds->institution_id = $institution_id;
        $tds->fiscal_year_id = $fiscal_year_id;
        $tds->save();
        return redirect()->route('tds-cert-letter');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tds = TdsCertificationLetter::where('id', $id)->first();
//        dd($tds->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
