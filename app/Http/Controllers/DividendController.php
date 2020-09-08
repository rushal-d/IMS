<?php

namespace App\Http\Controllers;

use App\Dividend;
use App\FiscalYear;
use App\Share;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class DividendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dividends = Dividend::latest()->paginate(30);
        $i = 1;
        return view('dividend.index', compact('dividends', 'i'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $distinct_share_institutions = Share::with('instituteByCode')->select('institution_code')->distinct()->get();
        $share_institutions = array();
        foreach ($distinct_share_institutions as $institutions) {
            $share_institutions[$institutions->institution_code] = $institutions->instituteByCode->institution_name;
        }
        return view('dividend.create', compact('share_institutions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = Input::all();
        $fiscal_year = FiscalYear::where('start_date_en', '<=', $input['date'])->where('start_date_en', '>=', $input['date'])->first();
        if (!empty($fiscal_year)) {
            $input['fiscal_year_id'] = $fiscal_year->id;
        }
        $status_mesg = Dividend::create($input);
        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Dividend added successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->back()->with($notification);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dividend $dividend
     * @return \Illuminate\Http\Response
     */
    public function show(Dividend $dividend)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dividend $dividend
     * @return \Illuminate\Http\Response
     */
    public function edit(Dividend $dividend)
    {
        $distinct_share_institutions = Share::with('instituteByCode')->select('institution_code')->distinct()->get();
        $share_institutions = array();
        foreach ($distinct_share_institutions as $institutions) {
            $share_institutions[$institutions->institution_code] = $institutions->instituteByCode->institution_name;
        }
        return view('dividend.edit', compact('dividend', 'share_institutions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Dividend $dividend
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dividend $dividend)
    {
        $input = Input::all();
        $fiscal_year = FiscalYear::where('start_date_en', '<=', $input['date'])->where('start_date_en', '>=', $input['date'])->first();
        if (!empty($fiscal_year)) {
            $input['fiscal_year_id'] = $fiscal_year->id;
        }
        $status_mesg = $dividend->update($input);
        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Dividend added successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('dividend.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dividend $dividend
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dividend $dividend)
    {
        $status_mesg=$dividend->delete();
        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Dividend Deleted successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('dividend.index')->with($notification);
    }
}
