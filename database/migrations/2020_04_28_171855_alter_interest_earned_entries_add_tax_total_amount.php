<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterInterestEarnedEntriesAddTaxTotalAmount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('interest_earned_entries', function (Blueprint $table) {
            $table->float('tax')->default(0);
            $table->double('total_amount', 12, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('interest_earned_entries', function (Blueprint $table) {
            $table->dropColumn('tax');
            $table->dropColumn('total_amount');
        });
    }
}
