<?php

namespace App\Http\Controllers;

use App\Documentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class DocumentationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documentations=Documentation::all();
        $i=1;
        return view('documentation.index',compact('documentations','i'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('documentation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $file = $request->file('filename');
        //Move Uploaded File
        $destinationPath = 'documents';
        $file->move($destinationPath,$file->getClientOriginalName());
        $input=Input::all();
        $input['filename']=$file->getClientOriginalName();
        $documentation=Documentation::create($input);

        $status = ($documentation) ? 'success' : 'error';
        $mesg = ($documentation) ? 'Document added successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('documentation.index')->with($notification);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Documentation $documentation
     * @return \Illuminate\Http\Response
     */
    public function show(Documentation $documentation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Documentation $documentation
     * @return \Illuminate\Http\Response
     */
    public function edit(Documentation $documentation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Documentation $documentation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Documentation $documentation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Documentation $documentation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Documentation $documentation)
    {
        //
    }
}
