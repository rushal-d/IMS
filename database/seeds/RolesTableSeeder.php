<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'administrator',
                'display_name' => 'God',
                'description' => 'All Access',
                'created_at' => '2018-06-20 18:50:59',
                'updated_at' => '2019-12-31 12:39:10',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Supervisor',
                'display_name' => 'Approver',
                'description' => 'This role contains the role to approve the records of Deposit, Share and Bond',
                'created_at' => '2019-01-10 16:25:53',
                'updated_at' => '2019-12-31 12:23:05',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Record Creator',
                'display_name' => 'Record Creator',
                'description' => 'The users with the role creates the record.',
                'created_at' => '2019-12-31 12:24:01',
                'updated_at' => '2019-12-31 12:24:01',
            ),
        ));
        
        
    }
}