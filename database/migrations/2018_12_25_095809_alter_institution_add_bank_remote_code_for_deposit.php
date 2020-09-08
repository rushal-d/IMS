<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterInstitutionAddBankRemoteCodeForDeposit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investment_institutions', function (Blueprint $table) {
            $table->string('remote_bank_code')->nullable();
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
            $table->dropColumn('remote_bank_code')->nullable();
        });
    }
}
