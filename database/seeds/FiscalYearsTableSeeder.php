<?php

use Illuminate\Database\Seeder;

class FiscalYearsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('fiscal_years')->delete();
        
        \DB::table('fiscal_years')->insert(array (
            0 => 
            array (
                'id' => 1,
                'start_date' => '2073-04-01',
                'start_date_en' => '2016-07-16',
                'end_date' => '2074-03-31',
                'end_date_en' => '2017-07-15',
                'code' => '2073/74',
                'status' => 0,
                'created_at' => '2018-10-08 17:17:21',
                'updated_at' => '2018-10-08 17:17:21',
            ),
            1 => 
            array (
                'id' => 2,
                'start_date' => '2074-04-01',
                'start_date_en' => '2017-07-16',
                'end_date' => '2075-03-32',
                'end_date_en' => '2018-07-16',
                'code' => '2074/75',
                'status' => 0,
                'created_at' => '2018-10-08 17:17:43',
                'updated_at' => '2018-10-08 17:17:43',
            ),
            2 => 
            array (
                'id' => 3,
                'start_date' => '2075-04-01',
                'start_date_en' => '2018-07-17',
                'end_date' => '2076-03-31',
                'end_date_en' => '2019-07-16',
                'code' => '2075/76',
                'status' => 0,
                'created_at' => '2018-10-08 17:18:10',
                'updated_at' => '2019-07-21 15:07:59',
            ),
            3 => 
            array (
                'id' => 4,
                'start_date' => '2076-04-01',
                'start_date_en' => '2019-07-17',
                'end_date' => '2077-03-31',
                'end_date_en' => '2020-07-15',
                'code' => '2076/77',
                'status' => 1,
                'created_at' => '2018-12-19 14:00:57',
                'updated_at' => '2020-01-20 10:01:30',
            ),
            4 => 
            array (
                'id' => 5,
                'start_date' => '2077-04-01',
                'start_date_en' => '2020-07-16',
                'end_date' => '2078-03-31',
                'end_date_en' => '2021-07-15',
                'code' => '2077/78',
                'status' => 0,
                'created_at' => '2019-07-31 16:06:19',
                'updated_at' => '2019-07-31 16:06:19',
            ),
            5 => 
            array (
                'id' => 6,
                'start_date' => '2078-04-01',
                'start_date_en' => '2021-07-16',
                'end_date' => '2079-03-32',
                'end_date_en' => '2022-07-16',
                'code' => '2078/79',
                'status' => 0,
                'created_at' => '2019-07-31 16:06:41',
                'updated_at' => '2019-07-31 16:06:41',
            ),
            6 => 
            array (
                'id' => 7,
                'start_date' => '2079-04-01',
                'start_date_en' => '2022-07-17',
                'end_date' => '2080-03-31',
                'end_date_en' => '2023-07-16',
                'code' => '2079/80',
                'status' => 0,
                'created_at' => '2019-07-31 16:07:04',
                'updated_at' => '2019-07-31 16:07:04',
            ),
            7 => 
            array (
                'id' => 8,
                'start_date' => '2080-04-01',
                'start_date_en' => '2023-07-17',
                'end_date' => '2081-03-32',
                'end_date_en' => '2024-07-15',
                'code' => '2080/81',
                'status' => 0,
                'created_at' => '2019-07-31 16:07:21',
                'updated_at' => '2019-07-31 16:07:21',
            ),
            8 => 
            array (
                'id' => 9,
                'start_date' => '2081-04-01',
                'start_date_en' => '2024-07-16',
                'end_date' => '2082-03-31',
                'end_date_en' => '2025-07-15',
                'code' => '2081/82',
                'status' => 0,
                'created_at' => '2019-07-31 16:08:43',
                'updated_at' => '2019-07-31 16:08:43',
            ),
            9 => 
            array (
                'id' => 10,
                'start_date' => '2082-04-01',
                'start_date_en' => '2025-07-16',
                'end_date' => '2083-03-32',
                'end_date_en' => '2026-07-16',
                'code' => '2082/83',
                'status' => 0,
                'created_at' => '2019-07-31 16:09:23',
                'updated_at' => '2019-07-31 16:09:23',
            ),
            10 => 
            array (
                'id' => 11,
                'start_date' => '2072-04-01',
                'start_date_en' => '2015-07-17',
                'end_date' => '2073-03-31',
                'end_date_en' => '2016-07-15',
                'code' => '2072/73',
                'status' => 0,
                'created_at' => '2019-12-04 11:22:28',
                'updated_at' => '2019-12-04 11:22:28',
            ),
            11 => 
            array (
                'id' => 12,
                'start_date' => '2071-04-01',
                'start_date_en' => '2014-07-17',
                'end_date' => '2072-03-31',
                'end_date_en' => '2015-07-16',
                'code' => '2071/72',
                'status' => 0,
                'created_at' => '2019-12-25 15:17:45',
                'updated_at' => '2019-12-25 15:17:45',
            ),
            12 => 
            array (
                'id' => 13,
                'start_date' => '2070-04-01',
                'start_date_en' => '2013-07-16',
                'end_date' => '2071-03-32',
                'end_date_en' => '2014-07-16',
                'code' => '2070/71',
                'status' => 0,
                'created_at' => '2019-12-25 15:18:22',
                'updated_at' => '2019-12-25 15:18:22',
            ),
            13 => 
            array (
                'id' => 14,
                'start_date' => '2069-04-01',
                'start_date_en' => '2012-07-16',
                'end_date' => '2070-03-31',
                'end_date_en' => '2013-07-15',
                'code' => '2069/70',
                'status' => 0,
                'created_at' => '2019-12-25 15:18:38',
                'updated_at' => '2019-12-25 15:18:38',
            ),
            14 => 
            array (
                'id' => 15,
                'start_date' => '2068-04-01',
                'start_date_en' => '2011-07-17',
                'end_date' => '2069-03-31',
                'end_date_en' => '2012-07-15',
                'code' => '2068/69',
                'status' => 0,
                'created_at' => '2019-12-25 15:19:11',
                'updated_at' => '2019-12-25 15:19:11',
            ),
        ));
        
        
    }
}