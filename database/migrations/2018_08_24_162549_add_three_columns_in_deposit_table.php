<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThreeColumnsInDepositTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->unsignedInteger('bank_id')->nullable();
            $table->unsignedInteger('bank_branch_id')->nullable();
            $table->string('accountnumber')->nullable();
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
            $table->dropColumn('bank_id');
            $table->dropColumn('bank_branch_id');
            $table->dropColumn('accountnumber');
        });
    }
}
