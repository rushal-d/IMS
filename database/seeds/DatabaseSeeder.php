<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *     * @return void
     */
    public function run()
    {
        $this->call(InvestmentTypeTableSeeder::class);
        $this->call(InvestmentGroupsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(RoleUserTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PermissionRoleTableSeeder::class);
        $this->call(FiscalYearsTableSeeder::class);
        $this->call(InvestmentSubTypesTableSeeder::class);
        $this->call(InvestmentInstitutionsTableSeeder::class);
        $this->call(DocumentationsTableSeeder::class);
        $this->call(MenusTableSeeder::class);
    }
}
