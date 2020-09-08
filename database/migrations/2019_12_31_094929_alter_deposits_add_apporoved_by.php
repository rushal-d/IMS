<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDepositsAddApporovedBy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->unsignedInteger('approved_by')->nullable();
            $table->timestamp('approved_date')->nullable();
            $table->foreign('approved_by')->references('id')->on('users');
        });

        Schema::table('deposit_withdraws', function (Blueprint $table) {
            $table->unsignedInteger('approved_by')->nullable();
            $table->timestamp('approved_date')->nullable();
            $table->foreign('approved_by')->references('id')->on('users');
        });

        Schema::table('shares', function (Blueprint $table) {
            $table->unsignedInteger('approved_by')->nullable();
            $table->timestamp('approved_date')->nullable();
            $table->foreign('approved_by')->references('id')->on('users');
        });
        Schema::table('agri_tour_water_investments', function (Blueprint $table) {
            $table->unsignedInteger('approved_by')->nullable();
            $table->timestamp('approved_date')->nullable();
            $table->foreign('approved_by')->references('id')->on('users');
        });
        Schema::table('bonds', function (Blueprint $table) {
            $table->unsignedInteger('approved_by')->nullable();
            $table->timestamp('approved_date')->nullable();
            $table->foreign('approved_by')->references('id')->on('users');
        });
        Schema::table('dividends', function (Blueprint $table) {
            $table->unsignedInteger('approved_by')->nullable();
            $table->timestamp('approved_date')->nullable();
            $table->foreign('approved_by')->references('id')->on('users');
        });
        Schema::table('land_building_investments', function (Blueprint $table) {
            $table->unsignedInteger('approved_by')->nullable();
            $table->timestamp('approved_date')->nullable();
            $table->foreign('approved_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn('approved_by');
            $table->dropColumn('approved_date');
        });
        Schema::table('deposit_withdraws', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn('approved_by');
            $table->dropColumn('approved_date');
        });
        Schema::table('shares', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn('approved_by');
            $table->dropColumn('approved_date');
        });
        Schema::table('agri_tour_water_investments', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn('approved_by');
            $table->dropColumn('approved_date');
        });
        Schema::table('bonds', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn('approved_by');
            $table->dropColumn('approved_date');
        });
        Schema::table('dividends', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn('approved_by');
            $table->dropColumn('approved_date');
        });
        Schema::table('land_building_investments', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn('approved_by');
            $table->dropColumn('approved_date');
        });
    }
}
