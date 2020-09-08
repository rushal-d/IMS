<?php

use Illuminate\Database\Seeder;

class InvestmentGroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('investment_groups')->delete();
        
        \DB::table('investment_groups')->insert(array (
            0 => 
            array (
                'id' => 1,
            'group_name' => 'दफा ६ संग सम्बन्धित (१)',
                'parent_id' => NULL,
                'percentage' => 5.0,
            'description' => 'Bond Issue by Nepal Rastra Bank (Guttered by Govt of Nepal)',
                'invest_type_id' => 1,
                'created_at' => '2018-06-04 09:41:38',
                'updated_at' => '2019-03-29 12:43:38',
                'enable' => 1,
                'group_code' => '101',
            ),
            1 => 
            array (
                'id' => 3,
                'group_name' => 'Class A Bank',
                'parent_id' => NULL,
                'percentage' => 40.0,
                'description' => 'Fixed deposit in Commercial Bank "KHA" Group',
                'invest_type_id' => 2,
                'created_at' => '2018-06-04 09:44:03',
                'updated_at' => '2019-03-29 12:43:42',
                'enable' => 1,
                'group_code' => '102',
            ),
            2 => 
            array (
                'id' => 4,
                'group_name' => 'Class B Bank',
                'parent_id' => NULL,
                'percentage' => 20.0,
                'description' => 'Fixed deposit in Development Bank "KHA" Group',
                'invest_type_id' => 2,
                'created_at' => '2018-06-04 09:47:09',
                'updated_at' => '2019-03-29 12:44:19',
                'enable' => 1,
                'group_code' => '110',
            ),
            3 => 
            array (
                'id' => 5,
                'group_name' => 'Class C Banks',
                'parent_id' => NULL,
                'percentage' => 10.0,
            'description' => 'Civil Investment Fund (Group Investment)',
                'invest_type_id' => 2,
                'created_at' => '2018-06-04 09:48:40',
                'updated_at' => '2019-03-29 12:44:24',
                'enable' => 1,
                'group_code' => '111',
            ),
            4 => 
            array (
                'id' => 9,
                'group_name' => 'Investment on share',
                'parent_id' => NULL,
                'percentage' => 10.0,
                'description' => 'Investment on share',
                'invest_type_id' => 3,
                'created_at' => '2018-06-04 09:55:37',
                'updated_at' => '2019-03-29 12:43:56',
                'enable' => 1,
                'group_code' => '105',
            ),
            5 => 
            array (
                'id' => 10,
                'group_name' => 'Investment in Promoter Share',
                'parent_id' => NULL,
                'percentage' => 20.0,
                'description' => 'Promotors shares in Commercial Bank, Development Bank and Financial Institutions',
                'invest_type_id' => 3,
                'created_at' => '2018-06-04 10:00:08',
                'updated_at' => '2019-03-29 12:44:00',
                'enable' => 1,
                'group_code' => '106',
            ),
            6 => 
            array (
                'id' => 11,
                'group_name' => 'Investment on Household and Land',
                'parent_id' => NULL,
                'percentage' => 5.0,
                'description' => NULL,
                'invest_type_id' => 3,
                'created_at' => '2018-06-04 10:03:22',
                'updated_at' => '2019-03-29 12:43:51',
                'enable' => 1,
                'group_code' => '104',
            ),
            7 => 
            array (
                'id' => 12,
                'group_name' => 'Agriculture, Tourism and Water Resources',
                'parent_id' => NULL,
                'percentage' => 20.0,
                'description' => NULL,
                'invest_type_id' => 3,
                'created_at' => '2018-06-04 10:04:40',
                'updated_at' => '2019-03-29 12:44:10',
                'enable' => 1,
                'group_code' => '108',
            ),
            8 => 
            array (
                'id' => 13,
                'group_name' => 'Citizen Investment Trust and Mutual Funds',
                'parent_id' => NULL,
                'percentage' => 5.0,
                'description' => NULL,
                'invest_type_id' => 3,
                'created_at' => '2018-06-04 10:08:09',
                'updated_at' => '2019-03-29 12:44:14',
                'enable' => 1,
                'group_code' => '109',
            ),
            9 => 
            array (
                'id' => 15,
                'group_name' => 'सुरक्षित देबेन्चर',
                'parent_id' => NULL,
                'percentage' => 20.0,
                'description' => NULL,
                'invest_type_id' => 3,
                'created_at' => '2019-03-29 10:29:19',
                'updated_at' => '2019-03-29 12:44:05',
                'enable' => 0,
                'group_code' => '107',
            ),
            10 => 
            array (
                'id' => 16,
                'group_name' => 'Infrastructure Bank',
                'parent_id' => NULL,
                'percentage' => NULL,
                'description' => NULL,
                'invest_type_id' => 2,
                'created_at' => '2019-03-29 12:38:39',
                'updated_at' => '2019-03-29 12:43:47',
                'enable' => 1,
                'group_code' => '103',
            ),
            11 => 
            array (
                'id' => 17,
                'group_name' => 'नेपाल राष्ट्र बैंकबाट इजजत्पत्र प्राप्त अन्य ऋणपत्र',
                'parent_id' => NULL,
                'percentage' => 5.0,
                'description' => 'Bond Issued By Institutions other than NRB',
                'invest_type_id' => 1,
                'created_at' => '2020-01-10 12:08:09',
                'updated_at' => '2020-01-10 12:08:09',
                'enable' => 1,
                'group_code' => '112',
            ),
        ));
        
        
    }
}