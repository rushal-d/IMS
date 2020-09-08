<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToDepositWithdraws extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deposit_withdraws', function(Blueprint $table){
            $table->unsignedInteger('withdraw_bank_id')->nullable();
            $table->unsignedInteger('withdraw_bank_branch_id')->nullable();
            $table->bigInteger('withdraw_account_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deposit_withdraws', function (Blueprint $table){
           $table->dropColumn('withdraw_bank_id')->nullable();
           $table->dropColumn('withdraw_bank_branch_id')->nullable();
           $table->dropColumn('withdraw_account_no')->nullable();
        });
    }
}
