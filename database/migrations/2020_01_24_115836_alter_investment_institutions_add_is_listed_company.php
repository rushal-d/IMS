<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterInvestmentInstitutionsAddIsListedCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investment_institutions', function (Blueprint $table) {
            $table->tinyInteger('is_listed')->default(1);
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
            $table->dropColumn('is_listed');
        });
    }
}
