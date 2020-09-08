<?php

namespace App\Console\Commands;

use App\Bond;
use App\Deposit;
use App\Helpers\BSDateHelper;
use Illuminate\Console\Command;

class CheckStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkstatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will check whether the fund is going to expire or not?';

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
        //check bonds expiry days
        $bonds = Bond::where('status','=',1)->get();
        $today_date =  date('Y-m-d');
        foreach ($bonds as $bond) {
            $bondstatus = 1;
            $mature_date = strtotime($bond->mature_date_en);
            $today = strtotime($today_date); //time to check alert days with today's date
            $datediff = $mature_date - $today;
            $expire_days = (int) floor(($datediff / (60 * 60 * 24)));
            $bond->expiry_days = $expire_days;
            if($expire_days <= 0){
                $bondstatus = 3;
            }
            if($expire_days <= $bond->alert_days and $expire_days > 0){
                $bondstatus = 2;
            }
            $bond->status = $bondstatus;
            $bond->save();
        }

        //check deposits expiry days
        $deposits = Deposit::whereIn('status',[1,2,3])->withoutGlobalScope('is_pending')->where('trans_date_en','<>',null)->where('mature_date_en','<>',null)->get();
        foreach ($deposits as $deposit) {
            $depositstatus = 1;
            $mature_date = strtotime($deposit->mature_date_en);
            $today = strtotime($today_date); //time to check alert days with today's date
            $datediff = $mature_date - $today;
            $expire_days = (int) floor(($datediff / (60 * 60 * 24)));
            $deposit->expiry_days = $expire_days;

            if($expire_days <= 0){
                $depositstatus = 3;
            }
            if($expire_days <= $deposit->alert_days and $expire_days > 0){
                $depositstatus = 2;
            }
            $deposit->status = $depositstatus;
            $deposit->save();
        }
    }
}
