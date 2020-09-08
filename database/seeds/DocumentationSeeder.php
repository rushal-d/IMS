<?php

use Illuminate\Database\Seeder;
use \App\Documentation;

class DocumentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();
        \App\Documentation::create( [
            'id'=>1,
            'title'=>'Bank Branch Excel Format',
            'filename'=>'BMP IMS Bank Branch Format.xlsx',
            'created_at'=>'2019-06-25 12:14:01',
            'updated_at'=>'2019-06-25 12:14:01'
        ] );

        Documentation::create( [
            'id'=>2,
            'title'=>'Organization Branch Excel Format',
            'filename'=>'IMS Org Branch Format.xlsx',
            'created_at'=>'2019-06-25 12:15:48',
            'updated_at'=>'2019-06-25 12:15:48'
        ] );

        Documentation::create( [
            'id'=>3,
            'title'=>'Deposit Import Excel Format',
            'filename'=>'Deposit Format.xlsx',
            'created_at'=>'2019-06-25 12:16:48',
            'updated_at'=>'2019-06-25 12:16:48'
        ] );

        Documentation::create( [
            'id'=>4,
            'title'=>'All Banks With Code',
            'filename'=>'BMP IMS All Banks.xlsx',
            'created_at'=>'2019-06-25 13:14:31',
            'updated_at'=>'2019-06-25 13:14:31'
        ] );
    }
}
