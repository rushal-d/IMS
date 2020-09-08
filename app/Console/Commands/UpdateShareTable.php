<?php

namespace App\Console\Commands;

use App\InvestmentInstitution;
use App\Share;
use App\ShareMarketToday;
use Illuminate\Console\Command;

class UpdateShareTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateshare';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command updates share table';

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
        $shares = Share::with('institute')->get();
        $current_share_market = ShareMarketToday::get();
        foreach ($shares as $share) {
            $share_institution_current_values = $current_share_market->where('organization_name', $share->institute->institution_name)->first();
            $total_closing = $share->purchase_kitta * $share_institution_current_values->closing_value;
            $share->rateperunit = $share_institution_current_values->closing_value;
            $share->closing_value = $total_closing;
            $share->save();
        }

        /*$allorg = ShareMarketToday::all();

        $org_id = array();
        foreach ($allorg as $org){
            foreach ($shares as $share){
                if($org->organization_name == $share->institute->institution_name){
                    array_push($org_id, $org->id);
                }
            }
        }

        $update_org = ShareMarketToday::findOrFail($org_id);
        foreach ($update_org as $organization) {
            $org_name = $organization->organization_name;
            $org_update = Share::with(['institute' => function($query) use ($org_name){
                $query->where('institution_name', 'like', '%'.$org_name.'%');
            }])->first();
            $today_nepse_rate = ShareMarketToday::select('closing_value')->where('organization_name','like','%'.$org_name.'%')->first();

            $total_closing = $org_update->purchase_kitta * $today_nepse_rate->closing_value;

            $shaaa = Share::with(['institute' => function($query) use ($org_name){
                $query->where('institution_name', 'like', '%'.$org_name.'%');
            }])->first();
            $shaaa->rateperunit = $today_nepse_rate->closing_value;
            $shaaa->closing_value = $total_closing;
            $shaaa->save();
        }*/

    }
}
