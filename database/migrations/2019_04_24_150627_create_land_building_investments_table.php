<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandBuildingInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('land_building_investments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fiscal_year_id')->nullable();
            $table->foreign('fiscal_year_id')->references('id')->on('fiscal_years');

            $table->string('site_location')->nullable();
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
        Schema::dropIfExists('land_building_investments');
    }
}
