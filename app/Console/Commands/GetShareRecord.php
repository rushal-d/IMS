<?php

namespace App\Console\Commands;

use App\SharePullDateRecord;
use App\ShareRecord;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GetShareRecord extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:share-record';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Getting Share Records';

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
        $share_pull_date_record = SharePullDateRecord::latest()->first();
        if (empty($share_pull_date_record)) {
            $input['record_date'] = '2010-04-15';
            $input['number_of_records'] = 0;
            $share_pull_date_record = SharePullDateRecord::create($input);
        }
        $client = new \GuzzleHttp\Client();
        $date_to_pull = date('Y-m-d', strtotime($share_pull_date_record->record_date . '+1 Day'));
        while (strtotime($date_to_pull) < strtotime(date('Y-m-d'))) {
            if ($date_to_pull < date('Y-m-d')) {
                $url = 'https://www.bmpinfology.xyz/nepserecord/public/index.php/api/get-share-records?date=' . $date_to_pull;
                /* $response = $client->request('GET', $url, [
                     'headers' => ['accept' => 'application/json'],
                     'curl' => array(CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false),
                 ]);
                 dd($response->getBody());*/

                $ch = curl_init();
                $headers = array(
                    'Accept: application/json',
                    'Content-Type: application/json',

                );

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                // Timeout in seconds
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);

                $response = curl_exec($ch);
                $datas = json_decode($response);
                $count_number_of_records = 0;
                try {
                    DB::beginTransaction();
                    $status = false;
                    foreach ($datas as $data) {
                        $input = array();
                        $input['organization_name'] = $data->organization_name;
                        $input['organization_code'] = $data->organization_code;
                        $input['closing_value'] = $data->closing_value;
                        $input['date'] = $data->date;
                        $input['date_np'] = $data->date_np;
                        ShareRecord::create($input);
                        $count_number_of_records++;
                    }
                    $input['record_date'] = $date_to_pull;
                    $input['number_of_records'] = $count_number_of_records;
                    $status = SharePullDateRecord::create($input);
                } catch (\Exception $e) {
                    dd($e);
                    DB::rollBack();
                }
                if ($status) {
                    DB::commit();
                }
                $date_to_pull = date('Y-m-d', strtotime($date_to_pull . '+1 Day'));
            }
        }
    }
}
