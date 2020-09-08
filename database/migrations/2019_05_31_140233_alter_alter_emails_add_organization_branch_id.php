<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAlterEmailsAddOrganizationBranchId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alert_emails', function (Blueprint $table) {
            $table->unsignedInteger('organization_branch_id')->nullable();
            $table->foreign('organization_branch_id')->references('id')->on('organization_branches');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alert_emails', function (Blueprint $table) {
            $table->dropForeign(['organization_branch_id']);
            $table->dropColumn('organization_branch_id');
        });
    }
}
