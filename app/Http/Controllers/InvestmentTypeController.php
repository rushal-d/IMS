<?php

namespace App\Http\Controllers;

use App\InvestmentSubType;
use App\InvestmentType;
use Illuminate\Http\Request;

class InvestmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $investmenttypes = InvestmentType::all();
        $investmentsubtypes = InvestmentSubType::all();
        $investmentsubtype = InvestmentSubType::orderBy('id','DESC')->first();

        if(!empty($investmentsubtype)){
            $code = $investmentsubtype->code + 1;
        }else{
            $code = 0001;
        }
        return view('investmenttype.index',compact('investmenttypes','investmentsubtypes','code'));
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
        $input = $request->all();
        InvestmentType::create($input);

        $notification = array(
            'message' => 'Data Added Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('investmenttype.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InvestmentType  $investmentType
     * @return \Illuminate\Http\Response
     */
    public function show(InvestmentType $investmentType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InvestmentType  $investmentType
     * @return \Illuminate\Http\Response
     */
    public function edit(InvestmentType $investmenttype)
    {
        $investmenttypes = InvestmentType::all();
        $investmentsubtypes = InvestmentSubType::all();

        return view('investmenttype.edit',compact('investmenttype','investmenttypes','investmentsubtypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InvestmentType  $investmentType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvestmentType $investmenttype)
    {
        $input = $request->all();
        $status_mesg = $investmenttype->update($input);

        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data updated Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('investmenttype.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InvestmentType  $investmentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvestmentType $investmenttype)
    {
        $status_mesg = $investmenttype->delete();

        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Deleted Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('investmenttype.index')->with($notification);
    }
}
