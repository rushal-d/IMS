<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit_withdraws', function (Blueprint $table) {
            $table->increments('id');
            $table->string('withdrawdate')->nullable();
            $table->date('withdrawdate_en')->nullable();
            $table->bigInteger('withdraw_amount')->nullable();
            $table->unsignedInteger('deposit_id');
            $table->timestamps();
	
	        $table->foreign('deposit_id')
		        ->references('id')->on('deposits')
		        ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposit_withdraws');
    }
}
