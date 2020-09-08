<?php

namespace App\Http\Controllers;

use App\SmsSetup;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SmsSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['sms_setups'] = SmsSetup::all();
        if ($data['sms_setups']->count() == 0) {
            return redirect()->route('sms-setup.create');
        }
        return view('sms-setup.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['sms_setups'] = SmsSetup::all();
        $data['count'] = 0;
        return view('sms-setup.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status_mesg = false;
        try {
            DB::beginTransaction();
            $input = $request->all();
            if (isset($input['parameter'])) {
                SmsSetup::truncate();
                $smsSetup = new SmsSetup();
                $smsSetup->parameter = 'url';
                $smsSetup->value = $input['url'];
                $smsSetup->save();
                $count = count($input['parameter']);
                for ($i = 0; $i < $count; $i++) {
                    if (!empty($input['parameter'][$i])) {
                        $parameter = $input['parameter'][$i];
                        $value = $input['value'][$i];
                        $smsSetup = new SmsSetup();
                        $smsSetup->parameter = $parameter;
                        $smsSetup->value = $value;
                        $smsSetup->save();
                    }
                }
            }
            $status_mesg = true;
        } catch (\Exception $e) {
            DB::rollBack();
            $status_mesg = false;
        }
        DB::commit();
        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data updated Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('sms-setup.index')->with($notification);
    }

    public function test(Request $request)
    {
        $status_mesg = false;
        $input = $request->all();

        $smsSetup = SmsSetup::get();
        $url = $smsSetup->where('parameter', 'url')->first()->value;
        $content = [];
        foreach ($smsSetup->where('parameter', '<>', 'url') as $smsParms) {
            if (strcasecmp($smsParms->value, '{mobile_number}') == 0) {
                $content[$smsParms->parameter] = rawurldecode($input['mobile_number']);
            } elseif (strcasecmp($smsParms->value, '{message}') == 0) {
                $content[$smsParms->parameter] = rawurldecode($input['message']);
            } else {
                $content[$smsParms->parameter] = rawurldecode($smsParms->value);
            }
        }
        $client = new Client();
        $response = $client->request('POST', $url, [
            'form_params' => $content
        ]);
        if ($response->getStatusCode() == 200) {
            $status_mesg = true;
        }
        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Successful' : 'Error Occured! Try Again!';
        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('sms-setup.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SmsSetup $smsSetup
     * @return \Illuminate\Http\Response
     */
    public function show(SmsSetup $smsSetup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SmsSetup $smsSetup
     * @return \Illuminate\Http\Response
     */
    public function edit(SmsSetup $smsSetup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\SmsSetup $smsSetup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SmsSetup $smsSetup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SmsSetup $smsSetup
     * @return \Illuminate\Http\Response
     */
    public function destroy(SmsSetup $smsSetup)
    {
        //
    }
}
