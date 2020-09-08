<?php

namespace App\Http\Controllers;

use App\EmailSetup;
use Illuminate\Http\Request;

class EmailSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $email_setup = EmailSetup::first();
        return view('emailsetup.index', compact('email_setup'));
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
        $input = $request->all();
        EmailSetup::create($input);

        $notification = array(
            'message' => 'Data Added Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('emailsetup.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EmailSetup $emailSetup
     * @return \Illuminate\Http\Response
     */
    public function show(EmailSetup $emailSetup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EmailSetup $emailSetup
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $emailSetup=EmailSetup::findorfail($id);
        $data['emailsetup'] = $emailSetup;
        return view('emailsetup.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\EmailSetup $emailSetup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $emailSetup=EmailSetup::findorfail($id);
        $input = $request->all();
        if (empty($input['password'])) {
            unset($input['password']);
        }
        $emailSetup->update($input);

        $notification = array(
            'message' => 'Data Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('emailsetup.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EmailSetup $emailSetup
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailSetup $emailSetup)
    {
        //
    }
}
