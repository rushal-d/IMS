<?php

namespace App\Console\Commands;

use App\Deposit;
use App\EmailSetup;
use App\Jobs\SendEmailJob;
use App\Mail\AlertEmail;
use App\SmsSetup;
use App\UserOrganization;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class InvestmentAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'investment:alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Investment Alert';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $alerts = \App\AlertEmail::get()->groupBy('organization_branch_id');
        $userOrganization = UserOrganization::first();
        foreach ($alerts as $organization_branch_id => $alert_users) {
            $emails = $alert_users->pluck('email')->toArray();
            $mobile_numbers = $alert_users->pluck('mobile_number')->toArray();

            $alertEmailDay = Config::get('constants.alert_email_days');
            $deposits = new Deposit();
            if (!empty($organization_branch_id)) {
                $deposits = $deposits->where('organization_branch_id', $organization_branch_id);
            }
            $deposits = $deposits->with('institute', 'branch')->whereIn('status', [1, 2, 3])->where('next_status', null);
            if ($userOrganization->organization_code == '0415') {
                $deposits = $deposits->whereYear('mature_date_en', date('Y'))->whereMonth('mature_date_en', date('m'));
            } else {
                $deposits = $deposits->where('expiry_days', '<=', $alertEmailDay);
            }
            $deposits = $deposits->get();

            if ($deposits->count() > 0) {
                $emailsetup = EmailSetup::first();
                if (!empty($emailsetup)) {
                    try {
                        /* Mail::to($emails)->send(new AlertEmail($deposits));*/
                        dispatch(new SendEmailJob($emails, $deposits));
                    } catch (\Exception $e) {
                    }
                }

                $message = 'Expiring Deposit:%0a';
                foreach ($deposits as $deposit) {
                    $message = $message . $deposit->institute->institution_code ?? '' . ' ';
                    $message = $message . ', ' . ($deposit->branch->branch_name ?? '') . ' ';
                    $message = $message . '(' . ($deposit->document_no ?? '') . ') ';
                    $message = $message . $deposit->expiry_days . ' Days %0a';
                }


                $smsSetup = SmsSetup::get();
                if ($smsSetup->where('parameter', 'url')->count() > 0) {
                    $url = $smsSetup->where('parameter', 'url')->first()->value;
                    $content = [];
                    foreach ($smsSetup->where('parameter', '<>', 'url') as $smsParms) {
                        if (strcasecmp($smsParms->value, '{mobile_number}') == 0) {
                            $content[$smsParms->parameter] = rawurldecode(implode(',', $mobile_numbers));
                        } elseif (strcasecmp($smsParms->value, '{message}') == 0) {
                            $content[$smsParms->parameter] = rawurldecode($message);
                        } else {
                            $content[$smsParms->parameter] = rawurldecode($smsParms->value);
                        }
                    }
                    $client = new Client();
                    $client->request('POST', $url, [
                        'form_params' => $content
                    ]);
                }
            }
        }
    }
}
