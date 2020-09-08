<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToBondsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bonds', function (Blueprint $table) {
            $table->unsignedInteger('interest_payment_method_id')->nullable();
            $table->unsignedInteger('receipt_location_id')->nullable();
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
        Schema::table('bonds', function (Blueprint $table) {
            $table->dropColumn('interest_payment_method_id');
            $table->dropColumn('receipt_location_id');
            $table->dropForeign(['organization_branch_id']);
            $table->dropColumn('organization_branch_id');
        });
    }
}
