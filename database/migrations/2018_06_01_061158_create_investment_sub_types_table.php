<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvestmentSubTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investment_sub_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->string('description',300)->nullable();
            $table->integer('code');
            $table->unsignedInteger('invest_type_id');
            $table->timestamps();

            $table->foreign('invest_type_id')
                ->references('id')->on('investment_types')
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
        Schema::dropIfExists('investment_sub_types');
    }
}
