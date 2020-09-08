<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'bmp',
                'email' => 'bmp@bmpinfology.com',
                'password' => '$2y$10$lfXbEuvG5jnT45rjy8UqFuAhxB6/8Owg3HbhdSpTUyfttJlbxsIay',
                'remember_token' => 'yYsM6UNTH0MfZAhligAI2TOeDWDPvtGbGGVYgDerJFjFJioqpCQ1DFpNUdT9',
                'created_at' => '2018-05-28 23:58:28',
                'updated_at' => '2018-06-23 00:35:26',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Manoj Shrestha',
                'email' => 'manoj.shrestha@nlgi.com.np',
                'password' => '$2y$10$u4lXR1J5HUWuxugdl17Br.NS9QFwnE7X/k5A.4Y.9gdf1xME9uzOK',
                'remember_token' => '1AYIdIiRxB0PilV2QukLFE7Mo60nVEom1X6KLBCw7uF4XCgpQQ7o19A4I1CM',
                'created_at' => '2019-12-08 12:58:52',
                'updated_at' => '2019-12-08 12:58:52',
            ),
            2 => 
            array (
                'id' => 4,
                'name' => 'Amrit Lal Shrestha',
                'email' => 'amrit.shrestha@nlgi.com.np',
                'password' => '$2y$10$07Vqh4meQx7oTLHF6oNmW.4Tk.wUUGz64O6HM/hktu6y2ziLvj.Bm',
                'remember_token' => 'qGIgz6EBwcfVwXSEn0KRmtH4B7i3cT57tdBmjw6u2gBzdzLcLEHEBdYVckBp',
                'created_at' => '2019-12-08 13:02:44',
                'updated_at' => '2019-12-08 13:02:44',
            ),
            3 => 
            array (
                'id' => 5,
                'name' => 'Surendra Pradhan',
                'email' => 's.pradhan@nlgi.com.np',
                'password' => '$2y$10$iypsCBNrlnVcl0kE2FCcp.d085u5YFxC45Ue/dil4E8bOqUuomdRm',
                'remember_token' => 'aU4W6woSXafnH514eLpRrEzWIlYtwcIy7lWh0hn8u5hxdRlFEitVROOXHHs5',
                'created_at' => '2019-12-31 12:38:06',
                'updated_at' => '2019-12-31 12:38:06',
            ),
            4 => 
            array (
                'id' => 6,
                'name' => 'Samip Wagle',
                'email' => 'samip.wagle@nlgi.com.np',
                'password' => '$2y$10$USeMTyLA6CpFk/oqNW30tOtSprCEtwrpE4i8Slelrb4Kfa7B.xXHa',
                'remember_token' => NULL,
                'created_at' => '2020-01-13 16:01:13',
                'updated_at' => '2020-01-13 16:01:13',
            ),
            5 => 
            array (
                'id' => 7,
                'name' => 'Sujita Khadka',
                'email' => 'sujita.khadka@nlgi.com.np',
                'password' => '$2y$10$XdVgZfAtZjBtjbpfmYkFZe9huXtymeuCC22zLsMH8uEwQ8u5jvGxW',
                'remember_token' => 'tqRjXhXGGJxTD8HGWn2Ap6Ix9rAJtLalEBHAjDUSqRg5GvmjIV9pa3N5sTH8',
                'created_at' => '2020-01-13 16:01:42',
                'updated_at' => '2020-01-13 16:01:42',
            ),
            6 => 
            array (
                'id' => 8,
                'name' => 'Alika Tuladhar',
                'email' => 'alika.tuladhar@nlgi.com.np',
                'password' => '$2y$10$TA2LhT0u0gk8snMiRJvH/O2tLgsXRAyUKFEKD8o7brPdkqnqU1SDu',
                'remember_token' => '4gcH04ZAaKc4Gps5JEXNwSDcuYxFy2ayGbtBYrv1UiBHYcjBeQksLZnfBL6U',
                'created_at' => '2020-01-13 16:02:07',
                'updated_at' => '2020-01-13 16:02:07',
            ),
            7 => 
            array (
                'id' => 9,
                'name' => 'Binod Lamichhane',
                'email' => 'binod.lamichhane@nlgi.com.np',
                'password' => '$2y$10$8U4rO1uNELTiDcPibqapQ.k2NWXGjjlcIuuiS7gOabkLy/IVv8rBC',
                'remember_token' => 'psgVH4dNBkud0MKLlIiulBjUxw0mr7GrEyA75U5AcdNxfjptISPNZqDhxwut',
                'created_at' => '2020-01-13 16:06:47',
                'updated_at' => '2020-01-13 16:06:47',
            ),
            8 => 
            array (
                'id' => 10,
                'name' => 'Roshani Aryal',
                'email' => 'roshani.aryal@nlgi.com.np',
                'password' => '$2y$10$aT3PUJiLKdvRHiRzrCrKvesfhQK4YWAnDbxpNed98coiNRYhsslFG',
                'remember_token' => 'PAKn7FvZV1rHkLjGGDHNi87CGJVQ4O5okOjzp5dSYx8cOyQPUSgqk162Lqun',
                'created_at' => '2020-01-13 16:07:13',
                'updated_at' => '2020-01-13 16:07:13',
            ),
            9 => 
            array (
                'id' => 11,
                'name' => 'Ashok Kadayat',
                'email' => 'ashok.kadayat@nlgi.com.np',
                'password' => '$2y$10$oJdWAgP7zyVN2ciN/7LWQOKHMUvNgXRKrgSfPRIHtYNYNUnBH0inq',
                'remember_token' => 'Q1YuTfVIp3ajmrpupTs8NY8w7YzydwdHf0aWGwsqOFXdiuyNoMGDCEOwfagS',
                'created_at' => '2020-01-13 16:07:46',
                'updated_at' => '2020-01-13 16:07:46',
            ),
            10 => 
            array (
                'id' => 12,
                'name' => 'prativa',
                'email' => 'prativa.wagle@nlgi.com.np',
                'password' => '$2y$10$Gu.FzOofKw5t8HqFpIDwQ.l1doluScr07TldH8kF7DERmmKcREuL2',
                'remember_token' => 'NNIH0WRkABggwePpzPAkHnIu77yF1wzakhI70vMKRG6JUx23MtQvOcfWRwPj',
                'created_at' => '2020-01-14 14:51:52',
                'updated_at' => '2020-01-14 14:51:52',
            ),
        ));
        
        
    }
}