<?php

namespace App\Http\Controllers;

use App\FiscalYear;
use App\LandBuildingInvestment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class LandBuildingInvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['fiscal_years'] = FiscalYear::all();
        $data['investment_through'] = Config::get('constants.land_building_investment_type');
        $investment = new LandBuildingInvestment();
        if (!empty($request->fiscal_year_id)) {
            $investment = $investment->where('fiscal_year_id', $request->fiscal_year_id);
        }
        if (!empty($request->start_date)) {
            $investment = $investment->where('date_en', '>=', $request->start_date);
        }
        if (!empty($request->end_date)) {
            $investment = $investment->where('date_en', '<=', $request->end_date);
        }
        if (!empty($request->investment_through)) {
            $investment = $investment->where('type', $request->investment_through);
        }

        $data['investments'] = $investment->latest()->paginate(50);

        $data['investment_total'] = $data['investments']->sum('amount');
        return view('landbuilding.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['investment_types'] = Config::get('constants.land_building_investment_type');
        return view('landbuilding.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = \Validator::make($input, [
            'date_en' => 'required',
            'date' => 'required',
            'type' => 'required',
            'site_location' => 'required',
            'amount' => 'required',

        ],

            [
                'date_en' => 'Please select date (AD)',
                'date' => 'Please select date (AD)',
                'type' => 'Please select investment type',
                'site_location' => 'Please select site location',
                'amount' => 'Please select amount',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        } else {
            $input['fiscal_year_id'] = FiscalYear::where('start_date_en', '<=', $input['date_en'])->where('end_date_en', '>=', $input['date_en'])->first()->id;

            $status_mesg = LandBuildingInvestment::create($input);
            $status = ($status_mesg) ? 'success' : 'error';
            $mesg = ($status_mesg) ? 'Data added successfully' : 'Error Occured! Try Again!';

            $notification = array(
                'message' => $mesg,
                'alert-type' => $status,
            );
            return redirect()->route('land-building-investments.index')->with($notification);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LandBuildingInvestment  $landBuildingInvestment
     * @return \Illuminate\Http\Response
     */
    public function show(LandBuildingInvestment $landBuildingInvestment)
    {
        $data['investment'] = $landBuildingInvestment;
        $data['investment_types'] = Config::get('constants.land_building_investment_type');
        return view('landbuilding.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LandBuildingInvestment  $landBuildingInvestment
     * @return \Illuminate\Http\Response
     */
    public function edit(LandBuildingInvestment $landBuildingInvestment)
    {
        $data['investment'] = $landBuildingInvestment;
        $data['investment_types'] = Config::get('constants.land_building_investment_type');
        return view('landbuilding.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LandBuildingInvestment  $landBuildingInvestment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LandBuildingInvestment $landBuildingInvestment)
    {
        $input = $request->all();
        $validator = \Validator::make($input, [
            'date_en' => 'required',
            'date' => 'required',
            'type' => 'required',
            'site_location' => 'required',
            'amount' => 'required',

        ],

            [
                'date_en' => 'Please select date (AD)',
                'date' => 'Please select date (AD)',
                'type' => 'Please select investment type',
                'site_location' => 'Please select site location',
                'amount' => 'Please select amount',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        } else {
            $input['fiscal_year_id'] = FiscalYear::where('start_date_en', '<=', $input['date_en'])->where('end_date_en', '>=', $input['date_en'])->first()->id;

            $status_mesg = $landBuildingInvestment->update($input);
            $status = ($status_mesg) ? 'success' : 'error';
            $mesg = ($status_mesg) ? 'Data updated successfully' : 'Error Occured! Try Again!';

            $notification = array(
                'message' => $mesg,
                'alert-type' => $status,
            );
            return redirect()->route('land-building-investments.index')->with($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LandBuildingInvestment  $landBuildingInvestment
     * @return \Illuminate\Http\Response
     */
    public function destroy(LandBuildingInvestment $landBuildingInvestment)
    {
        $status_mesg = $landBuildingInvestment->delete();
        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data deleted successfully' : 'Error Occured! Try Again!';
        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('land-building-investments.index')->with($notification);
    }
}
