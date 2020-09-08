<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToInvestmentInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investment_institutions', function (Blueprint $table) {
            $table->unsignedInteger('invest_type_id');

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
        Schema::table('investment_institutions', function (Blueprint $table) {
            //
        });
    }
}
