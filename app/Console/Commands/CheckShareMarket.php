<?php

namespace App\Console\Commands;

use App\InvestmentInstitution;
use App\ShareMarketToday;
use Goutte\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckShareMarket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'todayprice';

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
        $share_related_institutions = InvestmentInstitution::where('invest_type_id', 3)->get();
        $client = new Client();
        $crawler = $client->request('GET', 'http://www.nepalstock.com/todaysprice?_limit=500');

        $nodeValues = $crawler->filter('table tr')->each(function ($node) {
            return $node->text();
        });

        $arrayoflists = [];

        foreach ($nodeValues as $nodeValue){
            $arrayoflists[] = $nodeValue;
        }

        $mainarray = [];

        foreach ($arrayoflists as $arrayoflist){
            $childarray = [];
            $main = explode("\n",$arrayoflist);
            foreach ($main as $m){
                $m = trim($m,' ');
                if(!empty($m)){
                    $childarray[] = $m;
                }
            }
            if($childarray[0] == 'S.N.'){
                continue;
            }
            if(count($childarray) == 10 ) {
                $mainarray[] = $childarray;
            }
        }

        foreach ($mainarray as $child){
            $childarrayone = [];
            $childarrayone['organization_name'] = $child[1];
            $childarrayone['closing_value'] = $child[5];

            $institution = $share_related_institutions->where('institution_name', $child[1])->first();
            $childarrayone['code'] = NULL;
            if (!empty($institution)) {
                $childarrayone['code'] = $institution->institution_code;
            }
            $array_order[] = $childarrayone;
        }

        DB::table('shares_today')->delete();
        
        foreach ($array_order as $item){
            $share = new  ShareMarketToday();
            $share->organization_name = $item['organization_name'];
            $share->closing_value = $item['closing_value'];
            $share->code = $item['code'];
            $share->save();
        }

    }
}
