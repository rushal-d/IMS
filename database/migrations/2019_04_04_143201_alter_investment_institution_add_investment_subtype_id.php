<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterInvestmentInstitutionAddInvestmentSubtypeId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investment_institutions', function (Blueprint $table) {
            $table->unsignedInteger('invest_subtype_id')->nullable();
            $table->foreign('invest_subtype_id')->references('id')->on('investment_sub_types');
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
            $table->dropForeign(['invest_subtype_id']);
            $table->dropColumn('invest_subtype_id');
        });
    }
}
