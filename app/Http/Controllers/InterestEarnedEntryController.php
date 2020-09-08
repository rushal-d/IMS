<?php

namespace App\Http\Controllers;

use App\InterestEarnedEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class InterestEarnedEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['deposit_id'] = $request->id;
        return view('interestearned.create', $data);
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
            'amount' => 'required',
            'date_en' => 'required',
            'date' => 'required',
        ]);
        $input = Input::all();
        $input['total_amount'] = $request->amount + ($request->tax ?? 0);
        $status_mesg = InterestEarnedEntry::create($input);
        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data Added Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('deposit.show', $input['deposit_id'])->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\InterestEarnedEntry $interestEarnedEntry
     * @return \Illuminate\Http\Response
     */
    public function show(InterestEarnedEntry $interestearnedentry)
    {
        $data['interestearned'] = $interestearnedentry;
        return view('interestearned.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\InterestEarnedEntry $interestEarnedEntry
     * @return \Illuminate\Http\Response
     */
    public function edit(InterestEarnedEntry $interestearnedentry)
    {
        $data['interestearned'] = $interestearnedentry;
        return view('interestearned.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\InterestEarnedEntry $interestEarnedEntry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InterestEarnedEntry $interestearnedentry)
    {
        $this->validate($request, [
            'amount' => 'required',
            'date_en' => 'required',
            'date' => 'required',
        ]);
        $input = Input::all();
        $input['total_amount'] = $request->amount + ($request->tax ?? 0);
        $status_mesg = $interestearnedentry->update($input);
        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data Updated Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('deposit.show', $input['deposit_id'])->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\InterestEarnedEntry $interestEarnedEntry
     * @return \Illuminate\Http\Response
     */
    public function destroy(InterestEarnedEntry $interestearnedentry)
    {
        $deposit_id = $interestearnedentry->deposit_id;
        $status_mesg = $interestearnedentry->delete();
        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Deleted Successfully' : 'Error Occured! Try Again!';
        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('deposit.show', $deposit_id)->with($notification);
    }
}
