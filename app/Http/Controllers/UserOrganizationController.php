<?php

namespace App\Http\Controllers;

use App\ShareMarketToday;
use App\UserOrganization;
use Goutte\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class UserOrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deposit = 0;
        $userorganization = UserOrganization::all()->first();
        return view('userorganization.index', compact('userorganization'));
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $request->all();
        UserOrganization::create($input);

        $notification = array(
            'message' => 'Data Added Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('userorganization.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\UserOrganization $userOrganization
     * @return \Illuminate\Http\Response
     */
    public function show(UserOrganization $userOrganization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\UserOrganization $userorganization
     * @return \Illuminate\Http\Response
     */
    public function edit(UserOrganization $userorganization)
    {
        return view('userorganization.edit', compact('userorganization'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\UserOrganization $userorganization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserOrganization $userorganization)
    {
        $input = $request->all();
        $status_mesg = $userorganization->update($input);

        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data updated Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('userorganization.index')->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\UserOrganization $userorganization
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserOrganization $userorganization)
    {
        //
    }

    public function depositExcelExportColumn()
    {
        $userOrganization = UserOrganization::first();
        $depositExcelFields = Config::get('constants.deposit_export_fields');
        $depositExcelSelected = explode(',', $userOrganization->deposit_excel_columns);
        return view('userorganization.depositcolumnselect', compact('depositExcelFields', 'depositExcelSelected'));
    }

    public function depositExcelExportColumnSave(Request $request)
    {
        $deposit_excel_columns = implode(',', $request->fieldSelected);
        $userOrganization = UserOrganization::first();
        if (empty($userOrganization)) {
            $userOrganization = new UserOrganization();
        }
        $userOrganization->deposit_excel_columns = $deposit_excel_columns;
        $status_mesg = $userOrganization->save();

        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data updated Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->back()->with($notification);
    }
}
