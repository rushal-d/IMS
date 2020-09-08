<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterInvestmentInstitutionsAddMergerColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investment_institutions', function (Blueprint $table) {
            $table->boolean('is_merger')->nullable();
            $table->date('merger_date')->nullable();
            $table->unsignedInteger('merger_display_id')->nullable();
            $table->foreign('merger_display_id')->on('investment_institutions')->references('id');
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
            $table->dropForeign(['merger_display_id']);
            $table->dropColumn('merger_display_id');
            $table->dropColumn('merger_date');
            $table->dropColumn('is_merger');
        });
    }
}
