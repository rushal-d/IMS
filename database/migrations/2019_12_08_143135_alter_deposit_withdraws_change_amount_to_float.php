<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDepositWithdrawsChangeAmountToFloat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deposit_withdraws', function (Blueprint $table) {
            $table->float('withdraw_amount',14,2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deposit_withdraws', function (Blueprint $table) {
            $table->bigInteger('withdraw_amount')->change();
        });
    }
}
