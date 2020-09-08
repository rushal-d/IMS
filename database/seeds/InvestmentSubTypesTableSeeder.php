<?php

use Illuminate\Database\Seeder;

class InvestmentSubTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('investment_sub_types')->delete();
        
        \DB::table('investment_sub_types')->insert(array (
            0 => 
            array (
                'id' => 1,
            'name' => 'दफा ६ संग सम्बन्धित (१)',
            'description' => 'Bond Issue by Nepal Rastra Bank (Guttered by Govt of Nepal)',
                'code' => 101,
                'invest_type_id' => 1,
                'created_at' => '2018-06-04 09:41:38',
                'updated_at' => '2019-04-24 11:26:09',
                'percentage' => 5.0,
            ),
            1 => 
            array (
                'id' => 3,
                'name' => 'Class A Bank',
                'description' => 'Fixed deposit in Commercial Bank "KHA" Group',
                'code' => 102,
                'invest_type_id' => 2,
                'created_at' => '2018-06-04 09:44:03',
                'updated_at' => '2019-04-24 11:26:24',
                'percentage' => 40.0,
            ),
            2 => 
            array (
                'id' => 4,
                'name' => 'Class B Bank',
                'description' => 'Fixed deposit in Development Bank "KHA" Group',
                'code' => 110,
                'invest_type_id' => 2,
                'created_at' => '2018-06-04 09:47:09',
                'updated_at' => '2019-04-24 11:26:40',
                'percentage' => 20.0,
            ),
            3 => 
            array (
                'id' => 5,
                'name' => 'Class C Banks',
            'description' => 'Civil Investment Fund (Group Investment)',
                'code' => 111,
                'invest_type_id' => 2,
                'created_at' => '2018-06-04 09:48:40',
                'updated_at' => '2019-04-24 11:26:48',
                'percentage' => 10.0,
            ),
            4 => 
            array (
                'id' => 9,
                'name' => 'Investment on share',
                'description' => 'Investment on share',
                'code' => 105,
                'invest_type_id' => 3,
                'created_at' => '2018-06-04 09:55:37',
                'updated_at' => '2019-04-24 11:27:07',
                'percentage' => 10.0,
            ),
            5 => 
            array (
                'id' => 10,
                'name' => 'Investment in Promoter Share',
                'description' => 'Promotors shares in Commercial Bank, Development Bank and Financial Institutions',
                'code' => 106,
                'invest_type_id' => 3,
                'created_at' => '2018-06-04 10:00:08',
                'updated_at' => '2019-04-24 11:27:23',
                'percentage' => 20.0,
            ),
            6 => 
            array (
                'id' => 11,
                'name' => 'Investment on Household and Land',
                'description' => NULL,
                'code' => 104,
                'invest_type_id' => 3,
                'created_at' => '2018-06-04 10:03:22',
                'updated_at' => '2019-04-24 11:27:55',
                'percentage' => 5.0,
            ),
            7 => 
            array (
                'id' => 12,
                'name' => 'Agriculture, Tourism and Water Resources',
                'description' => NULL,
                'code' => 108,
                'invest_type_id' => 3,
                'created_at' => '2018-06-04 10:04:40',
                'updated_at' => '2019-04-24 11:28:08',
                'percentage' => 20.0,
            ),
            8 => 
            array (
                'id' => 13,
                'name' => 'Citizen Investment Trust and Mutual Funds',
                'description' => NULL,
                'code' => 109,
                'invest_type_id' => 3,
                'created_at' => '2018-06-04 10:08:09',
                'updated_at' => '2019-04-24 11:28:21',
                'percentage' => 5.0,
            ),
            9 => 
            array (
                'id' => 15,
                'name' => 'सुरक्षित देबेन्चर',
                'description' => NULL,
                'code' => 107,
                'invest_type_id' => 3,
                'created_at' => '2019-03-29 10:29:19',
                'updated_at' => '2019-04-24 11:28:32',
                'percentage' => 20.0,
            ),
            10 => 
            array (
                'id' => 16,
                'name' => 'Infrastructure Bank',
                'description' => NULL,
                'code' => 103,
                'invest_type_id' => 2,
                'created_at' => '2019-03-29 12:38:39',
                'updated_at' => '2019-03-29 12:43:47',
                'percentage' => 0.0,
            ),
            11 => 
            array (
                'id' => 17,
                'name' => 'नेपाल राष्ट्र बैंकबाट इजजत्पत्र प्राप्त अन्य ऋणपत्र',
                'description' => 'Bond Issued By Institutions other than NRB',
                'code' => 112,
                'invest_type_id' => 1,
                'created_at' => '2020-01-14 00:00:00',
                'updated_at' => '2020-01-14 00:00:00',
                'percentage' => 5.0,
            ),
        ));
        
        
    }
}