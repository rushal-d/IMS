<?php

namespace App\Http\Controllers;

use App\VersionChangeLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class VersionChangeLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $versions = VersionChangeLog::latest()->get();
        $i = 1;
        return view('versionchangelog.index', compact('versions', 'i'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('versionchangelog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = Input::all();
        $version = VersionChangeLog::create($input);

        $status = ($version) ? 'success' : 'error';
        $mesg = ($version) ? 'Version Log added successfully' : 'Error Occured! Try Again!';
        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('version-change-log.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\VersionChangeLog $versionChangeLog
     * @return \Illuminate\Http\Response
     */
    public function show(VersionChangeLog $versionChangeLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\VersionChangeLog $versionChangeLog
     * @return \Illuminate\Http\Response
     */
    public function edit(VersionChangeLog $versionChangeLog)
    {
        $data['version'] = $versionChangeLog;
        return view('versionchangelog.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\VersionChangeLog $versionChangeLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VersionChangeLog $versionChangeLog)
    {
        $input = Input::all();
        $version = $versionChangeLog->update($input);

        $status = ($version) ? 'success' : 'error';
        $mesg = ($version) ? 'Version Log Updated successfully' : 'Error Occured! Try Again!';
        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('version-change-log.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\VersionChangeLog $versionChangeLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(VersionChangeLog $versionChangeLog)
    {
        //
    }
}
