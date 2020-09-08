<?php

namespace App\Console\Commands;

use App\Helpers\BSDateHelper;
use App\InvestmentInstitution;
use App\SharePullDateRecord;
use App\ShareRecord;
use Goutte\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PullShareHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull:share';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $client = new Client();
        $date_to_pull = date('Y-m-d', strtotime($share_pull_date_record->record_date . '+1 Day'));

        while (strtotime($date_to_pull) < strtotime(date('Y-m-d'))) {

            if ($date_to_pull < date('Y-m-d')) {
                $crawler = $client->request('GET', 'http://www.nepalstock.com/todaysprice?_limit=500&startDate=' . $date_to_pull);

                $nodeValues = $crawler->filter('table tr')->each(function ($node) {
                    return $node->text();
                });
                $status = false;
                $share_related_institutions = InvestmentInstitution::where('invest_type_id', 3)->get();

                try {
                    DB::beginTransaction();
                    $count_number_of_records = 0; //count number of records on the given date
                    foreach ($nodeValues as $nodeValue) {
                        //creating an array of the node record
                        $record = explode("\n", $nodeValue);
                        //trim the white space and removing empty values using array_filter
                        $record = array_filter(array_map('trim', $record));

                        if (count($record) == 10) {

                            if (strcasecmp($record[1], 'S.N.') == 0) {
                                continue;
                            }
                            $input = array();
                            $institution = $share_related_institutions->where('institution_name', $record[2])->first();
                            if (!empty($institution)) {
                                $input['organization_code'] = $institution->institution_code;
                            }
                            $input['organization_name'] = $record[2];
                            $input['closing_value'] = $record[6];
                            $input['date'] = $date_to_pull;
                            $input['date_np'] = BSDateHelper::AdToBsEN('-', $date_to_pull);
                            ShareRecord::create($input);
                            $count_number_of_records++;
                        }
                    }
                    $input['record_date'] = $date_to_pull;
                    $input['number_of_records'] = $count_number_of_records;
                    SharePullDateRecord::create($input);

                    $status = true;
                } catch (\Exception $e) {
                    dd($e);
                    DB::rollBack();
                    $status = false;
                }
                if ($status) {
                    DB::commit();
                }
            }

            $date_to_pull = date('Y-m-d', strtotime($date_to_pull . '+1 Day'));
        }

        return false;
    }
}
