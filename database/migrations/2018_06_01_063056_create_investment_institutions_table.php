<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvestmentInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investment_institutions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('institution_name',200);
            $table->string('institution_code');
            $table->string('description')->nullable();
            $table->unsignedInteger('invest_group_id');
            $table->timestamps();

            $table->foreign('invest_group_id')
                ->references('id')->on('investment_groups')
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
        Schema::dropIfExists('investment_institutions');
    }
}
