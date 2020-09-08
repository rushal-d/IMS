<?php

namespace App\Http\Controllers;

use App\BonusShareHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class BonusShareHistoryController extends Controller
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
        $data['share_id'] = $request->id;
        return view('bonusharehistory.create', $data);

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
            'no_of_kitta' => 'required',
            'date_en' => 'required',
            'date' => 'required',
        ]);
        $input = Input::all();
        $status_mesg = BonusShareHistory::create($input);
        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data Added Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('share.show', $input['share_id'])->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BonusShareHistory $bonusShareHistory
     * @return \Illuminate\Http\Response
     */
    public function show(BonusShareHistory $bonussharehistory)
    {
        $data['bonussharehistory'] = $bonussharehistory;
        return view('bonusharehistory.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BonusShareHistory $bonusShareHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(BonusShareHistory $bonussharehistory)
    {
        $data['bonussharehistory'] = $bonussharehistory;
        return view('bonusharehistory.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\BonusShareHistory $bonusShareHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BonusShareHistory $bonussharehistory)
    {
        $this->validate($request, [
            'no_of_kitta' => 'required',
            'date_en' => 'required',
            'date' => 'required',
        ]);
        $input = Input::all();
        $status_mesg = $bonussharehistory->update($input);
        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data Updated Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('share.show', $input['share_id'])->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BonusShareHistory $bonusShareHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(BonusShareHistory $bonussharehistory)
    {
        $share_id = $bonussharehistory->share_id;
        $status_mesg = $bonussharehistory->delete();
        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Deleted Successfully' : 'Error Occured! Try Again!';
        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('share.show', $share_id)->with($notification);
    }
}
