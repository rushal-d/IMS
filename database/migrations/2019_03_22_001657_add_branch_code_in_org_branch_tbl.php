<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBranchCodeInOrgBranchTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organization_branches', function (Blueprint $table) {
            $table->string('branch_code')->nullable()->after('branch_name');
            $table->string('branch_name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organization_branches', function (Blueprint $table) {
            $table->dropColumn('branch_code');
            $table->string('branch_name')->nullable(false)->change();

        });
    }
}
