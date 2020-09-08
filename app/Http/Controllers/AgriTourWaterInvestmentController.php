<?php

namespace App\Http\Controllers;

use App\AgriTourWaterInvestment;
use App\FiscalYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class AgriTourWaterInvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['fiscal_years'] = FiscalYear::all();
        $data['investment_areas'] = Config::get('constants.investment_areas');
        $data['investment_through'] = Config::get('constants.investment_through');
        $investment = new AgriTourWaterInvestment();
        if (!empty($request->fiscal_year_id)) {
            $investment = $investment->where('fiscal_year_id', $request->fiscal_year_id);
        }
        if (!empty($request->start_date)) {
            $investment = $investment->where('date_en', '>=', $request->start_date);
        }
        if (!empty($request->end_date)) {
            $investment = $investment->where('date_en', '<=', $request->end_date);
        }
        if (!empty($request->investment_area)) {
            $investment = $investment->where('investment_area', $request->investment_area);
        }
        if (!empty($request->investment_through)) {
            $investment = $investment->where('type', $request->investment_through);
        }

        $data['investments'] = $investment->latest()->paginate(50);

        $data['investment_total'] = $data['investments']->sum('amount');
        return view('agritourwater.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['investment_areas'] = Config::get('constants.investment_areas');
        $data['investment_through'] = Config::get('constants.investment_through');
        return view('agritourwater.create', $data);
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
        $validator = \Validator::make($input, [
            'date_en' => 'required',
            'date' => 'required',
            'type' => 'required',
            'investment_area' => 'required',
            'amount' => 'required',

        ],

            [
                'date_en' => 'Please select date (AD)',
                'date' => 'Please select date (AD)',
                'type' => 'Please select investment type',
                'investment_area' => 'Please select investment area',
                'amount' => 'Please select amount',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        } else {
            $input['fiscal_year_id'] = FiscalYear::where('start_date_en', '<=', $input['date_en'])->where('end_date_en', '>=', $input['date_en'])->first()->id;

            $status_mesg = AgriTourWaterInvestment::create($input);
            $status = ($status_mesg) ? 'success' : 'error';
            $mesg = ($status_mesg) ? 'Data added successfully' : 'Error Occured! Try Again!';

            $notification = array(
                'message' => $mesg,
                'alert-type' => $status,
            );
            return redirect()->route('agri-tour-water-investments.index')->with($notification);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\AgriTourWaterInvestment $agriTourWaterInvestment
     * @return \Illuminate\Http\Response
     */
    public function show(AgriTourWaterInvestment $agriTourWaterInvestment)
    {
        $data['investment'] = $agriTourWaterInvestment;
        $data['investment_areas'] = Config::get('constants.investment_areas');
        $data['investment_through'] = Config::get('constants.investment_through');
        return view('agritourwater.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\AgriTourWaterInvestment $agriTourWaterInvestment
     * @return \Illuminate\Http\Response
     */
    public function edit(AgriTourWaterInvestment $agriTourWaterInvestment)
    {
            $data['investment'] = $agriTourWaterInvestment;
            $data['investment_areas'] = Config::get('constants.investment_areas');
            $data['investment_through'] = Config::get('constants.investment_through');
            return view('agritourwater.edit', $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\AgriTourWaterInvestment $agriTourWaterInvestment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AgriTourWaterInvestment $agriTourWaterInvestment)
    {
        $input = $request->all();
        $validator = \Validator::make($input, [
            'date_en' => 'required',
            'date' => 'required',
            'type' => 'required',
            'investment_area' => 'required',
            'amount' => 'required',

        ],

            [
                'date_en' => 'Please select date (AD)',
                'date' => 'Please select date (AD)',
                'type' => 'Please select investment type',
                'investment_area' => 'Please select investment area',
                'amount' => 'Please select amount',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        } else {
            $input['fiscal_year_id'] = FiscalYear::where('start_date_en', '<=', $input['date_en'])->where('end_date_en', '>=', $input['date_en'])->first()->id;

            $status_mesg = $agriTourWaterInvestment->update($input);
            $status = ($status_mesg) ? 'success' : 'error';
            $mesg = ($status_mesg) ? 'Data updated successfully' : 'Error Occured! Try Again!';

            $notification = array(
                'message' => $mesg,
                'alert-type' => $status,
            );
            return redirect()->route('agri-tour-water-investments.index')->with($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\AgriTourWaterInvestment $agriTourWaterInvestment
     * @return \Illuminate\Http\Response
     */
    public function destroy(AgriTourWaterInvestment $agriTourWaterInvestment)
    {
        $status_mesg = $agriTourWaterInvestment->delete();
        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data deleted successfully' : 'Error Occured! Try Again!';
        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('agri-tour-water-investments.index')->with($notification);
    }
}
