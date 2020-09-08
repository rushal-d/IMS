<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDepositsAddBankMergerId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->unsignedInteger('bank_merger_id')->nullable();
            $table->foreign('bank_merger_id')->references('id')->on('bank_mergers');
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
            $table->dropForeign(['bank_merger_id']);
            $table->dropColumn('bank_merger_id');
        });
    }
}
