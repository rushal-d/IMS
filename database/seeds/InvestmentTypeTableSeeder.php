<?php

use Illuminate\Database\Seeder;

class InvestmentTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\InvestmentType::firstOrCreate([
            'id' => '1',
            'name' => 'Bond',
            'description' => 'this is a bond',
        ]);
        \App\InvestmentType::firstOrCreate([
            'id' => '2',
            'name' => 'Deposit',
            'description' => 'this is a deposit',
        ]);
        \App\InvestmentType::firstOrCreate([
            'id' => '3',
            'name' => 'Share',
            'description' => 'this is a share',
        ]);
    }
}
