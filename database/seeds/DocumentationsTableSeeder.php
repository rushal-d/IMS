<?php

use Illuminate\Database\Seeder;

class DocumentationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('documentations')->delete();
        
        \DB::table('documentations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Bank Branch Import Format',
                'filename' => 'Bank Branch Import.xlsx',
                'created_at' => '2019-08-08 16:16:14',
                'updated_at' => '2019-08-08 16:16:14',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Organization Branch Import Format',
                'filename' => 'Organization Branch Import.xlsx',
                'created_at' => '2019-08-08 16:16:34',
                'updated_at' => '2019-08-08 16:16:34',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Deposit Import Format',
                'filename' => 'Deposit Import Format.xlsx',
                'created_at' => '2019-08-08 16:16:46',
                'updated_at' => '2019-08-08 16:16:46',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'Share Import Format',
                'filename' => 'Share Import Format.xlsx',
                'created_at' => '2019-08-08 16:16:59',
                'updated_at' => '2019-08-08 16:16:59',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'Business Book Import Format',
                'filename' => 'Business Book Import Format.xlsx',
                'created_at' => '2019-08-08 16:18:36',
                'updated_at' => '2019-08-08 16:18:36',
            ),
        ));
        
        
    }
}