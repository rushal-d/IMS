<?php

namespace App\Http\Controllers;

use App\AlertEmail;
use App\AlertEmailInvestmentType;
use App\InvestmentType;
use App\OrganizationBranch;
use Illuminate\Http\Request;

class AlertEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['i'] = 1;
        $data['alert_emails'] = AlertEmail::paginate(20);
        return view('alertemail.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['organization_branches'] = OrganizationBranch::pluck('branch_name', 'id');
        $data['investment_types'] = InvestmentType::get();
        return view('alertemail.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = \Validator::make($input, [
            'email' => 'unique:alert_emails',
        ],
            [
                'email.unique' => 'Email Already Exists!',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        } else {
            $alertEmail = AlertEmail::create($input);

            $status = ($alertEmail) ? 'success' : 'error';
            $mesg = ($alertEmail) ? 'Added successfully' : 'Error Occured! Try Again!';

            $notification = array(
                'message' => $mesg,
                'alert-type' => $status,
            );
            return redirect()->route('alertEmails.index')->with($notification);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\AlertEmail $alertEmail
     * @return \Illuminate\Http\Response
     */
    public function show(AlertEmail $alertEmail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\AlertEmail $alertEmail
     * @return \Illuminate\Http\Response
     */
    public function edit(AlertEmail $alertEmail)
    {
        $data['organization_branches'] = OrganizationBranch::pluck('branch_name', 'id');
        $data['alertEmail'] = $alertEmail;
        return view('alertemail.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\AlertEmail $alertEmail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AlertEmail $alertEmail)
    {
        $input = $request->all();
        $validator = \Validator::make($input, [
            'email' => 'unique:alert_emails,id,' . $alertEmail->id,
        ],
            [
                'email.unique' => 'Email Already Exists!',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        } else {
            $alertEmail = $alertEmail->update($input);

            $status = ($alertEmail) ? 'success' : 'error';
            $mesg = ($alertEmail) ? 'Updated successfully' : 'Error Occured! Try Again!';

            $notification = array(
                'message' => $mesg,
                'alert-type' => $status,
            );
            return redirect()->route('alertEmails.index')->with($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\AlertEmail $alertEmail
     * @return \Illuminate\Http\Response
     */
    public function destroy(AlertEmail $alertEmail)
    {
        $status = $alertEmail->delete();

        $status = ($status) ? 'success' : 'error';
        $mesg = ($status) ? 'Deleted successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('alertEmails.index')->with($notification);
    }
}
