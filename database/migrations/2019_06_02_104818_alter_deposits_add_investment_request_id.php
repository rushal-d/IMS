<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDepositsAddInvestmentRequestId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->unsignedInteger('investment_request_id')->nullable();
            $table->foreign('investment_request_id')
                ->references('id')->on('investment_requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropForeign(['investment_request_id']);
            $table->dropColumn('investment_request_id');
        });
    }
}
