<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableDepositWithdrawsAddWithdrawLetter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deposit_withdraws', function (Blueprint $table){
           $table->mediumText('withdraw_letter')->nullable();
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
            $table->dropColumn('withdraw_letter');
        });
    }
}
