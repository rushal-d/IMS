<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBonusShareHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus_share_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('share_id');
            $table->foreign('share_id')->references('id')->on('shares');
            $table->date('date_en');
            $table->string('date');
            $table->integer('no_of_kitta');
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
        Schema::dropIfExists('bonus_share_histories');
    }
}
