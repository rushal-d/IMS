<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMergeBankListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merge_bank_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bank_merger_id');
            $table->foreign('bank_merger_id')->references('id')->on('bank_mergers');
            $table->string('bank_name');
            $table->string('bank_code');
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
        Schema::dropIfExists('merge_bank_lists');
    }
}
