<?php

namespace App\Http\Controllers;

use App\OrganizationBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class OrganizationBranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['i'] = 1;
        $data['organization_branches'] = OrganizationBranch::all();
        return view('organizationbranch.index', $data);
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
        OrganizationBranch::create($input);
        return redirect()->route('organizationbranch.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrganizationBranch $organizationBranch
     * @return \Illuminate\Http\Response
     */
    public function show(OrganizationBranch $organizationBranch)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrganizationBranch $organizationBranch
     * @return \Illuminate\Http\Response
     */
    public function edit(OrganizationBranch $organizationbranch)
    {
        $data['organization_branch'] = $organizationbranch;
        $data['i'] = 1;
        $data['organization_branches'] = OrganizationBranch::all();
        return view('organizationbranch.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\OrganizationBranch $organizationBranch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrganizationBranch $organizationbranch)
    {
        $input = Input::all();
        $organizationbranch->update($input);
        return redirect()->route('organizationbranch.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrganizationBranch $organizationBranch
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrganizationBranch $organizationbranch)
    {
        if (!empty($organizationbranch->depositBankB1->first())) {
            $status = 'error';
            $mesg = 'You cannot delete this, its already being used!';
        } else {
            $status_mesg = $organizationbranch->delete();
            $status = ($status_mesg) ? 'success' : 'error';
            $mesg = ($status_mesg) ? 'Deleted Successfully' : 'Error Occured! Try Again!';
        }

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('organizationbranch.index')->with($notification);
    }

    public function excelImport(Request $request)
    {
        try {
            $status = false;
            DB::beginTransaction();
            $path = $request->file('organizationbranch_excel')->getRealPath();
            $datas = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {
            })->all();
            foreach ($datas as $data) {
                $organization_branch = new OrganizationBranch();
                if (strcasecmp($data['branch_name'], 'END') == 0) {
                    break;
                }
                $organization_branch->branch_name = $data['branch_name'];
                if (!empty($data['description'])) {
                    $organization_branch->description = $data['description'];
                }
                if (!empty($data['branch_code'])) {
                    $organization_branch->branch_code = $data['branch_code'];
                }
                $organization_branch->save();
            }
            $status = true;
        } catch (\Exception $e) {
            DB::rollBack();
        }
        if ($status) {
            DB::commit();
            $mesg = "Data  Uploaded Succesfully";
        } else {
            $mesg = "Error Occured!!";
        }
        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('organizationbranch.index')->with($notification);

    }

    public function ajaxEntry(Request $request)
    {
        $organization_branch = new OrganizationBranch();
        $organization_branch->branch_name = $request->branch_name;
        $organization_branch->save();
        return response($organization_branch->id);
    }
}
