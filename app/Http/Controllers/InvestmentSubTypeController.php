<?php

namespace App\Http\Controllers;

use App\InvestmentSubType;
use App\InvestmentType;
use Illuminate\Http\Request;

class InvestmentSubTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required | unique:investment_sub_types',
        ]);

        $input = $request->all();
        InvestmentSubType::create($input);

        $notification = array(
            'message' => 'Data Added Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('investmenttype.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InvestmentSubType $investmentSubType
     * @return \Illuminate\Http\Response
     */
    public function show(InvestmentSubType $investmentSubType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InvestmentSubType $investmentSubType
     * @return \Illuminate\Http\Response
     */
    public function edit(InvestmentSubType $investmentsubtype)
    {
        $investmenttypes = InvestmentType::all();
        $investmentsubtypes = InvestmentSubType::all();

        return view('investmenttype.edit', compact('investmentsubtype', 'investmenttypes', 'investmentsubtypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\InvestmentSubType $investmentSubType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvestmentSubType $investmentsubtype)
    {
        $this->validate($request, [
            'code' => 'required | unique:investment_sub_types,code,' . $investmentsubtype->id,
        ]);
        $input = $request->all();
        $status_mesg = $investmentsubtype->update($input);

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
     * @param  \App\InvestmentSubType $investmentSubType
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvestmentSubType $investmentsubtype)
    {

        if ((!empty($investmentsubtype->bond->count()) || !empty($investmentsubtype->deposit->count()) || !empty($investmentsubtype->share->count()))) {
            $status = 'error';
            $mesg = 'Cannot Delete, It is already being used !';
        } else {
            $status_mesg = $investmentsubtype->delete();
            $status = ($status_mesg) ? 'success' : 'error';
            $mesg = ($status_mesg) ? 'Deleted Successfully' : 'Error Occured! Try Again!';
        }
        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('investmenttype.index')->with($notification);
    }
}
