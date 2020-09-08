<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgriTourWaterInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agri_tour_water_investments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fiscal_year_id')->nullable();
            $table->foreign('fiscal_year_id')->references('id')->on('fiscal_years');

            $table->unsignedInteger('investment_area')->nullable();
            $table->date('date_en')->nullable();
            $table->string('date')->nullable();
            $table->integer('type')->nullable(); // loan or cash
            $table->double('amount', 40, 2)->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('agri_tour_water_investments');
    }
}
