<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\OrganizationBranch;
use App\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = OrganizationBranch::pluck('branch_name', 'id');
        $staffs = Staff::all();
        $i = 1;
        return view('staff.index', compact('branches', 'staffs', 'i'));
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
        $input = Input::all();
        $staff = Staff::create($input);

        $status = ($staff) ? 'success' : 'error';
        $mesg = ($staff) ? 'Data Added Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('staff.index')->with($notification);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Staff $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        return view('staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Staff $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        $branches = OrganizationBranch::pluck('branch_name', 'id');
        $staffs = Staff::all();
        $i = 1;
        return view('staff.edit', compact('branches', 'staff', 'staffs', 'i'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Staff $staff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Staff $staff)
    {
        $input = Input::all();
        $staff = $staff->update($input);
        $status = ($staff) ? 'success' : 'error';
        $mesg = ($staff) ? 'Data Updated Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('staff.index')->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Staff $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        $deposit = Deposit::where('staff_id', $staff->id)->first();
        if (empty($deposit)) {
            $status_mesg = $staff->delete();
            $status = ($status_mesg) ? 'success' : 'error';
            $mesg = ($status_mesg) ? 'Deleted Successfully' : 'Error Occured! Try Again!';
        } else {
            $status = 'error';
            $mesg = 'You cannot delete this, It\'s already being used!';
        }

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('staff.index')->with($notification);
    }

    public function ajaxEntry(Request $request)
    {
        $input = Input::all();
        $staff = Staff::create($input);
        return response()->json($staff->id);
    }
}
