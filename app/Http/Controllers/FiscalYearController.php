<?php

namespace App\Http\Controllers;

use App\FiscalYear;
use Illuminate\Http\Request;


class FiscalYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $fiscalyears = FiscalYear::orderBy('code','ASC')->get();
        return view('fiscalyear.index',compact('fiscalyears'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  /*public function create()
    {
        return view('fiscalyear.create');
    }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required | unique:fiscal_years',
        ]);

        $input = $request->all();
        FiscalYear::create($input);

        $notification = array(
            'message' => 'Data Added Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('fiscalyear.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FiscalYear  $fiscalYear
     * @return \Illuminate\Http\Response
     */
    public function show(FiscalYear $fiscalYear)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FiscalYear  $fiscalYear
     * @return \Illuminate\Http\Response
     */
    public function edit(FiscalYear $fiscalyear)
    {
        $fiscalyears = FiscalYear::orderBy('code','ASC')->get();
        return view('fiscalyear.edit',compact('fiscalyear','fiscalyears'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FiscalYear  $fiscalYear
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FiscalYear $fiscalyear)
    {
        $this->validate($request, [
            'code' => 'required | unique:fiscal_years,id,'.$fiscalyear->id,
        ]);

        $input = $request->all();
        $status_mesg = $fiscalyear->update($input);

        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data updated Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('fiscalyear.edit',$fiscalyear->id)->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FiscalYear  $fiscalYear
     * @return \Illuminate\Http\Response
     */
    public function destroy(FiscalYear $fiscalyear)
    {
        if(!empty($fiscalyear->bond) || !empty($fiscalyear->deposit) || !empty($fiscalyear->share)){
            $status = 'error';
            $mesg = 'Cannot Delete, It is already being used !';
        }else {
            $status_mesg = $fiscalyear->delete();
            $status = ($status_mesg) ? 'success' : 'error';
            $mesg = ($status_mesg) ? 'Deleted Successfully' : 'Error Occured! Try Again!';
        }
        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('fiscalyear.index')->with($notification);
    }
}
