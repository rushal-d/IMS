<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['i']=1;
        $data['roles']=Role::all();
        return view('entrust.role.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('entrust.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = new Role();
        $role->name = $request->role_name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();
        $notification = array(
            'message' => 'Data Added Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('role.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('entrust.role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $input = $request->all();
        $role->update($input);
        $notification = array(
            'message' => 'Data Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('role.index')->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $status_mesg = $role->delete();

        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Deleted Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('role.index')->with($notification);
    }
}
