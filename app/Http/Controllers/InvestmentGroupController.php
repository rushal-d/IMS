<?php

namespace App\Http\Controllers;

use App\InvestmentGroup;
use App\InvestmentType;
use Illuminate\Http\Request;

class InvestmentGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $investmentgroups = InvestmentGroup::with('child')->where('parent_id', null)->orderBy('group_code')->get();
        $investmenttypes = InvestmentType::all();
        $group_parents = InvestmentGroup::where('parent_id', null)->get();
        return view('investmentgroup.index', compact('investmenttypes', 'investmentgroups', 'group_parents'));
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
            'group_name' => 'required | unique:investment_groups',
            'group_code' => 'required | unique:investment_groups',
            'invest_type_id' => 'required',
        ]);

        $input = $request->all();
        InvestmentGroup::create($input);

        $notification = array(
            'message' => 'Data Added Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('investmentgroup.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InvestmentGroup $investmentGroup
     * @return \Illuminate\Http\Response
     */
    public function show(InvestmentGroup $investmentGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InvestmentGroup $investmentGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(InvestmentGroup $investmentgroup)
    {
        $investmentgroups = InvestmentGroup::with('child')->where('parent_id', null)->orderBy('group_code')->get();
        $investmenttypes = InvestmentType::all();
        $group_parents = InvestmentGroup::where('parent_id', null)->get();
        return view('investmentgroup.edit', compact('investmentgroup', 'investmentgroups', 'investmenttypes', 'group_parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\InvestmentGroup $investmentGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvestmentGroup $investmentgroup)
    {
        $this->validate($request, [
            'group_name' => 'required | unique:investment_groups,group_name,' . $investmentgroup->id,
            'group_code' => 'required | unique:investment_groups,group_name,' . $investmentgroup->id,
            'invest_type_id' => 'required',
        ]);

        $input = $request->all();
        $status_mesg = $investmentgroup->update($input);
        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data updated Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('investmentgroup.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InvestmentGroup $investmentGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvestmentGroup $investmentgroup)
    {
//        dd($investmentgroup->child->count());
        if ($investmentgroup->bond->count() > 0 || $investmentgroup->deposit->count() > 0 || $investmentgroup->share->count() > 0
            || $investmentgroup->invest_inst->count() > 0 || $investmentgroup->child->count() > 0) {
            $status = 'error';
            $mesg = 'Cannot Delete, It is already being used !';
        } else {
            $status_mesg = $investmentgroup->delete();

            $status = ($status_mesg) ? 'success' : 'error';
            $mesg = ($status_mesg) ? 'Deleted Successfully' : 'Error Occured! Try Again!';
        }
        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('investmentgroup.index')->with($notification);
    }
}
