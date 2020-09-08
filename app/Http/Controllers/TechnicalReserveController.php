<?php

namespace App\Http\Controllers;

use App\FiscalYear;
use App\TechnicalReserve;
use Illuminate\Http\Request;

class TechnicalReserveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['fiscal_years'] = FiscalYear::pluck('code', 'id');
        $data['technicalReserves'] = TechnicalReserve::latest()->paginate(20);
        return view('technicalreserve.index', $data);
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
            'approved_date' => 'required | unique:technical_reserves',
            'fiscal_year_id' => 'required',
        ]);

        $input = $request->all();
        TechnicalReserve::create($input);

        $notification = array(
            'message' => 'Data Added Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('technicalReserve.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TechnicalReserve $technicalReserve
     * @return \Illuminate\Http\Response
     */
    public function show(TechnicalReserve $technicalReserve)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TechnicalReserve $technicalReserve
     * @return \Illuminate\Http\Response
     */
    public function edit(TechnicalReserve $technicalReserve)
    {

        $data['fiscal_years'] = FiscalYear::pluck('code', 'id');
        $data['technicalReserves'] = TechnicalReserve::latest()->paginate(20);
        $data['technicalReserve'] = $technicalReserve;
        return view('technicalreserve.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\TechnicalReserve $technicalReserve
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TechnicalReserve $technicalReserve)
    {
        $this->validate($request, [
            'approved_date' => 'required | unique:technical_reserves,id,'.$technicalReserve->id,
            'fiscal_year_id' => 'required',
        ]);

        $input = $request->all();
        $technicalReserve->update($input);

        $notification = array(
            'message' => 'Data Added Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('technicalReserve.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TechnicalReserve $technicalReserve
     * @return \Illuminate\Http\Response
     */
    public function destroy(TechnicalReserve $technicalReserve)
    {
        $status_mesg = $technicalReserve->delete();
        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Deleted Successfully' : 'Error Occured! Try Again!';
        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('technicalReserve.index')->with($notification);
    }
}
