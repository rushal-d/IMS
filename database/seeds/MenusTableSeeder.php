<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menus')->delete();
        
        \DB::table('menus')->insert(array (
            0 => 
            array (
                'id' => 1,
                'display_name' => 'Dashboard',
                'menu_name' => '/',
                'icon' => 'fas fa-home',
                'parent_id' => NULL,
                'order' => 3,
                'created_at' => '2019-12-25 12:33:10',
                'updated_at' => '2019-12-25 12:41:20',
            ),
            1 => 
            array (
                'id' => 9,
                'display_name' => 'Bond',
                'menu_name' => 'bond.index',
                'icon' => 'fas fa-bold',
                'parent_id' => NULL,
                'order' => 4,
                'created_at' => '2019-12-25 12:33:21',
                'updated_at' => '2019-12-25 12:41:20',
            ),
            2 => 
            array (
                'id' => 16,
                'display_name' => 'Deposit',
                'menu_name' => 'deposit.index',
                'icon' => 'fas fa-money-bill-alt',
                'parent_id' => NULL,
                'order' => 6,
                'created_at' => '2019-12-25 12:33:51',
                'updated_at' => '2019-12-25 12:41:20',
            ),
            3 => 
            array (
                'id' => 24,
                'display_name' => 'Share',
                'menu_name' => 'share.index',
                'icon' => 'fas fa-share-square',
                'parent_id' => NULL,
                'order' => 7,
                'created_at' => '2019-12-25 12:34:04',
                'updated_at' => '2019-12-25 12:41:21',
            ),
            4 => 
            array (
                'id' => 40,
                'display_name' => 'Share Market',
                'menu_name' => 'share.market',
                'icon' => NULL,
                'parent_id' => 110,
                'order' => 14,
                'created_at' => '2019-12-25 12:52:12',
                'updated_at' => '2019-12-25 12:54:47',
            ),
            5 => 
            array (
                'id' => 42,
                'display_name' => 'Fiscal Year',
                'menu_name' => 'fiscalyear.index',
                'icon' => NULL,
                'parent_id' => 110,
                'order' => 2,
                'created_at' => '2019-12-25 12:47:46',
                'updated_at' => '2019-12-25 12:47:55',
            ),
            6 => 
            array (
                'id' => 47,
                'display_name' => 'Organization Setup',
                'menu_name' => 'userorganization.index',
                'icon' => NULL,
                'parent_id' => 110,
                'order' => 3,
                'created_at' => '2019-12-25 12:48:45',
                'updated_at' => '2019-12-25 12:54:46',
            ),
            7 => 
            array (
                'id' => 57,
                'display_name' => 'Investment Sector',
                'menu_name' => 'investmentsubtype.index',
                'icon' => NULL,
                'parent_id' => 110,
                'order' => 9,
                'created_at' => '2019-12-25 12:50:15',
                'updated_at' => '2019-12-25 12:54:47',
            ),
            8 => 
            array (
                'id' => 62,
                'display_name' => 'Investment Group',
                'menu_name' => 'investmentgroup.index',
                'icon' => NULL,
                'parent_id' => 110,
                'order' => 10,
                'created_at' => '2019-12-25 12:50:23',
                'updated_at' => '2019-12-25 12:54:47',
            ),
            9 => 
            array (
                'id' => 71,
                'display_name' => 'Bank Branch',
                'menu_name' => 'bankbranch.index',
                'icon' => NULL,
                'parent_id' => 110,
                'order' => 7,
                'created_at' => '2019-12-25 12:49:06',
                'updated_at' => '2019-12-25 12:54:46',
            ),
            10 => 
            array (
                'id' => 76,
                'display_name' => 'Bond Organizations',
                'menu_name' => 'bonds.index',
                'icon' => NULL,
                'parent_id' => 110,
                'order' => 13,
                'created_at' => '2019-12-25 12:51:54',
                'updated_at' => '2019-12-25 12:54:47',
            ),
            11 => 
            array (
                'id' => 77,
                'display_name' => 'Deposit Banks',
                'menu_name' => 'deposits.index',
                'icon' => NULL,
                'parent_id' => 110,
                'order' => 11,
                'created_at' => '2019-12-25 12:51:39',
                'updated_at' => '2019-12-25 12:54:47',
            ),
            12 => 
            array (
                'id' => 78,
                'display_name' => 'Share Organizations',
                'menu_name' => 'shares.index',
                'icon' => NULL,
                'parent_id' => 110,
                'order' => 12,
                'created_at' => '2019-12-25 12:51:48',
                'updated_at' => '2019-12-25 12:54:47',
            ),
            13 => 
            array (
                'id' => 79,
                'display_name' => 'Role',
                'menu_name' => 'role.index',
                'icon' => NULL,
                'parent_id' => 111,
                'order' => 3,
                'created_at' => '2019-12-25 12:55:14',
                'updated_at' => '2019-12-25 12:56:35',
            ),
            14 => 
            array (
                'id' => 86,
                'display_name' => 'Permission',
                'menu_name' => 'permission.index',
                'icon' => NULL,
                'parent_id' => 111,
                'order' => 4,
                'created_at' => '2019-12-25 12:55:25',
                'updated_at' => '2019-12-25 12:56:35',
            ),
            15 => 
            array (
                'id' => 95,
                'display_name' => 'Users',
                'menu_name' => 'user.index',
                'icon' => NULL,
                'parent_id' => 111,
                'order' => 2,
                'created_at' => '2019-12-25 12:55:06',
                'updated_at' => '2019-12-25 12:56:35',
            ),
            16 => 
            array (
                'id' => 102,
                'display_name' => 'Role - Permission',
                'menu_name' => 'assignrole.index',
                'icon' => NULL,
                'parent_id' => 111,
                'order' => 5,
                'created_at' => '2019-12-25 12:55:34',
                'updated_at' => '2019-12-25 12:56:35',
            ),
            17 => 
            array (
                'id' => 110,
                'display_name' => 'Setting',
                'menu_name' => '#settings',
                'icon' => 'fas fa-cogs',
                'parent_id' => NULL,
                'order' => 12,
                'created_at' => '2019-12-25 12:47:25',
                'updated_at' => '2019-12-25 12:56:34',
            ),
            18 => 
            array (
                'id' => 111,
                'display_name' => 'User Management',
                'menu_name' => '#user',
                'icon' => 'fas fa-users-cog',
                'parent_id' => NULL,
                'order' => 13,
                'created_at' => '2019-12-25 12:55:00',
                'updated_at' => '2019-12-25 12:56:35',
            ),
            19 => 
            array (
                'id' => 121,
                'display_name' => 'Report',
                'menu_name' => '#report',
                'icon' => 'fas fa-book',
                'parent_id' => NULL,
                'order' => 9,
                'created_at' => '2019-12-25 12:41:27',
                'updated_at' => '2019-12-25 12:45:50',
            ),
            20 => 
            array (
                'id' => 140,
                'display_name' => 'Deposit Interest Calculation Report',
                'menu_name' => 'report-interest-calc',
                'icon' => NULL,
                'parent_id' => 121,
                'order' => 5,
                'created_at' => '2019-12-25 12:43:43',
                'updated_at' => '2019-12-25 12:45:36',
            ),
            21 => 
            array (
                'id' => 141,
                'display_name' => 'Organization Branch',
                'menu_name' => 'organizationbranch.index',
                'icon' => NULL,
                'parent_id' => 110,
                'order' => 4,
                'created_at' => '2019-12-25 12:48:16',
                'updated_at' => '2019-12-25 12:54:46',
            ),
            22 => 
            array (
                'id' => 147,
                'display_name' => 'Business Book',
                'menu_name' => 'businessbook.index',
                'icon' => 'fas fa-book-reader',
                'parent_id' => NULL,
                'order' => 10,
                'created_at' => '2019-12-25 12:34:27',
                'updated_at' => '2019-12-25 12:45:50',
            ),
            23 => 
            array (
                'id' => 167,
                'display_name' => 'Deposit Summary Report',
                'menu_name' => 'report-summary-report',
                'icon' => NULL,
                'parent_id' => 121,
                'order' => 4,
                'created_at' => '2019-12-25 12:43:14',
                'updated_at' => '2019-12-25 12:45:36',
            ),
            24 => 
            array (
                'id' => 170,
                'display_name' => 'Org. Staff',
                'menu_name' => 'staff.index',
                'icon' => NULL,
                'parent_id' => 110,
                'order' => 6,
                'created_at' => '2019-12-25 12:48:32',
                'updated_at' => '2019-12-25 12:54:46',
            ),
            25 => 
            array (
                'id' => 188,
                'display_name' => 'Pending Deposit',
                'menu_name' => 'pending-deposit',
                'icon' => 'fas fa-stopwatch',
                'parent_id' => NULL,
                'order' => 5,
                'created_at' => '2019-12-25 12:33:34',
                'updated_at' => '2019-12-25 12:41:20',
            ),
            26 => 
            array (
                'id' => 192,
                'display_name' => 'Share Summary Report',
                'menu_name' => 'report-share-summary',
                'icon' => NULL,
                'parent_id' => 121,
                'order' => 6,
                'created_at' => '2019-12-25 12:42:56',
                'updated_at' => '2019-12-25 12:45:36',
            ),
            27 => 
            array (
                'id' => 193,
                'display_name' => 'Share History',
                'menu_name' => 'share-history',
                'icon' => NULL,
                'parent_id' => 121,
                'order' => 7,
                'created_at' => '2019-12-25 12:44:15',
                'updated_at' => '2019-12-25 12:45:36',
            ),
            28 => 
            array (
                'id' => 194,
                'display_name' => 'Share Value At Date',
                'menu_name' => 'share-price-at-date',
                'icon' => NULL,
                'parent_id' => 121,
                'order' => 8,
                'created_at' => '2019-12-25 12:44:34',
                'updated_at' => '2019-12-25 12:45:36',
            ),
            29 => 
            array (
                'id' => 203,
                'display_name' => 'Documentation',
                'menu_name' => 'documentation.index',
                'icon' => 'fas fa-file-contract',
                'parent_id' => NULL,
                'order' => 14,
                'created_at' => '2019-12-25 12:34:58',
                'updated_at' => '2019-12-25 12:56:34',
            ),
            30 => 
            array (
                'id' => 210,
                'display_name' => 'Share Dividend',
                'menu_name' => 'dividend.index',
                'icon' => 'fas fa-hand-holding-usd',
                'parent_id' => NULL,
                'order' => 8,
                'created_at' => '2019-12-25 12:34:13',
                'updated_at' => '2019-12-25 12:41:21',
            ),
            31 => 
            array (
                'id' => 219,
                'display_name' => 'Investment Report',
                'menu_name' => 'investment-report',
                'icon' => NULL,
                'parent_id' => 121,
                'order' => 2,
                'created_at' => '2019-12-25 12:42:00',
                'updated_at' => '2019-12-25 12:42:08',
            ),
            32 => 
            array (
                'id' => 220,
                'display_name' => 'SMTP Email Setup',
                'menu_name' => 'emailsetup.index',
                'icon' => NULL,
                'parent_id' => 110,
                'order' => 16,
                'created_at' => '2019-12-25 12:52:35',
                'updated_at' => '2019-12-25 12:54:47',
            ),
            33 => 
            array (
                'id' => 225,
                'display_name' => 'Alert Email',
                'menu_name' => 'alertEmails.index',
                'icon' => NULL,
                'parent_id' => 110,
                'order' => 15,
                'created_at' => '2019-12-25 12:52:21',
                'updated_at' => '2019-12-25 12:54:47',
            ),
            34 => 
            array (
                'id' => 232,
                'display_name' => 'SMS Setup',
                'menu_name' => 'sms-setup.index',
                'icon' => NULL,
                'parent_id' => 110,
                'order' => 17,
                'created_at' => '2019-12-25 12:52:41',
                'updated_at' => '2019-12-25 12:54:47',
            ),
            35 => 
            array (
                'id' => 237,
                'display_name' => 'Technical Reserve',
                'menu_name' => 'technicalReserve.index',
                'icon' => NULL,
                'parent_id' => 110,
                'order' => 5,
                'created_at' => '2019-12-25 12:48:24',
                'updated_at' => '2019-12-25 12:54:46',
            ),
            36 => 
            array (
                'id' => 249,
                'display_name' => 'Deposit Inv. %',
                'menu_name' => 'institution.deposit.percentage',
                'icon' => NULL,
                'parent_id' => 121,
                'order' => 9,
                'created_at' => '2019-12-25 12:44:51',
                'updated_at' => '2019-12-25 12:45:36',
            ),
            37 => 
            array (
                'id' => 250,
                'display_name' => 'Investment Sector %',
                'menu_name' => 'investment.sector.percentage',
                'icon' => NULL,
                'parent_id' => 121,
                'order' => 10,
                'created_at' => '2019-12-25 12:44:51',
                'updated_at' => '2019-12-25 12:45:36',
            ),
            38 => 
            array (
                'id' => 259,
                'display_name' => 'Investment Request',
                'menu_name' => 'investment-request.index',
                'icon' => 'fas fa-tty',
                'parent_id' => NULL,
                'order' => 11,
                'created_at' => '2019-12-25 12:34:43',
                'updated_at' => '2019-12-25 12:45:50',
            ),
            39 => 
            array (
                'id' => 271,
                'display_name' => 'Deposit by Org. Branch',
                'menu_name' => 'deposit-org-branch',
                'icon' => NULL,
                'parent_id' => 121,
                'order' => 11,
                'created_at' => '2019-12-25 12:45:21',
                'updated_at' => '2019-12-25 12:45:36',
            ),
            40 => 
            array (
                'id' => 275,
                'display_name' => 'Total Deposit Report',
                'menu_name' => 'report-total-deposit-report',
                'icon' => NULL,
                'parent_id' => 121,
                'order' => 3,
                'created_at' => '2019-12-25 12:42:22',
                'updated_at' => '2019-12-25 12:45:36',
            ),
            41 => 
            array (
                'id' => 286,
                'display_name' => 'Bank Merger',
                'menu_name' => 'bank-merger.index',
                'icon' => NULL,
                'parent_id' => 110,
                'order' => 8,
                'created_at' => '2019-12-25 12:49:15',
                'updated_at' => '2019-12-25 12:54:47',
            ),
            42 => 
            array (
                'id' => 303,
                'display_name' => 'Menu Builder',
                'menu_name' => 'menu.index',
                'icon' => NULL,
                'parent_id' => 111,
                'order' => 6,
                'created_at' => '2019-12-25 12:55:40',
                'updated_at' => '2019-12-25 12:56:35',
            ),
        ));
        
        
    }
}