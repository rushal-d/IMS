<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterestEarnedEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interest_earned_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('deposit_id');
            $table->foreign('deposit_id')->references('id')->on('deposits');
            $table->double('amount');
            $table->date('date_en');
            $table->string('date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interest_earned_entries');
    }
}
