<?php

namespace App\Http\Controllers;

use App\BankBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BankBranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bankbranches = BankBranch::all();
        return view('bankbranch.index', compact('bankbranches'));
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
            'branch_name' => 'required | unique:bank_branches',
        ]);

        $input = $request->all();
        BankBranch::create($input);

        $notification = array(
            'message' => 'Data Added Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('bankbranch.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BankBranch $bankBranch
     * @return \Illuminate\Http\Response
     */
    public function show(BankBranch $bankbranch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BankBranch $bankBranch
     * @return \Illuminate\Http\Response
     */
    public function edit(BankBranch $bankbranch)
    {
        $bankbranches = BankBranch::all();
        return view('bankbranch.edit', compact('bankbranches', 'bankbranch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\BankBranch $bankBranch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BankBranch $bankbranch)
    {
        $this->validate($request, [
            'branch_name' => 'required | unique:bank_branches,branch_name,' . $bankbranch->id,
        ]);

        $input = $request->all();
        $status_mesg = $bankbranch->update($input);
        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data updated Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('bankbranch.index')->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BankBranch $bankBranch
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankBranch $bankbranch)
    {
        if (!empty($bankbranch->depositBankB1->count()) || !empty($bankbranch->depositBankB2->count())) {
            $status = 'error';
            $mesg = 'You cannot delete this, its already being used!';
        } else {
            $status_mesg = $bankbranch->delete();
            $status = ($status_mesg) ? 'success' : 'error';
            $mesg = ($status_mesg) ? 'Deleted Successfully' : 'Error Occured! Try Again!';
        }

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('bankbranch.index')->with($notification);
    }

    public function excelImport(Request $request)
    {
        try {
            $status = false;
            DB::beginTransaction();
            $path = $request->file('bankbranch_excel')->getRealPath();
            $datas = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {
            })->all();
            foreach ($datas as $data) {
                if (strcasecmp($data['branch_name'], 'END') == 0) {
                    break;
                }
                $bankbranch = new BankBranch();
                $bankbranch->branch_name = $data['branch_name'];
                if (!empty($data['description'])) {
                    $bankbranch->description = $data['description'];
                }
                $bankbranch->save();
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
        return redirect()->route('bankbranch.index')->with($notification);

    }

    public function ajaxEntry(Request $request)
    {
        $bank_branch = new BankBranch();
        $bank_branch->branch_name = $request->branch_name;
        $bank_branch->save();
        return response($bank_branch->id);
    }
}
