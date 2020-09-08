<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $i = 1;
        $users = User::all();
        return view('entrust.user.index', compact('i', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('entrust.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'roles' => 'required'
        ]);
        $input = $request->only('name', 'email', 'password');
        $input['password'] = Hash::make($input['password']); //Hash password
        $user = User::create($input); //Create User table entry
        //Attach the selected Roles
        foreach ($request->input('roles') as $key => $value) {
            $user->attachRole($value);
        }
        return redirect()->route('user.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray();
        return view('entrust.user.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,id,' . $id,
            'password' => 'confirmed',
            'roles' => 'required'
        ]);

        $input = $request->only('name', 'email', 'password');
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']); //Hash password
        } else {
            unset($input['password']);
        }
        User::findOrFail($id)->update($input); //Create User table entry
        $user = User::findOrFail($id);
        $user->roles()->sync($request->input('roles'));

        return redirect()->route('user.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status_mesg = User::findOrFail($id)->delete();
        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Deleted Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('user.index')->with($notification);
    }
}
