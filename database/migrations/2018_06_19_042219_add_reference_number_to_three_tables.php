<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReferenceNumberToThreeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->string('reference_number')->after('status')->nullable();
        });

        Schema::table('bonds', function (Blueprint $table) {
            $table->string('reference_number')->after('status')->nullable();
        });

        Schema::table('shares', function (Blueprint $table) {
            $table->string('reference_number')->after('status')->nullable();
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
            $table->dropColumn('reference_number');
        });

        Schema::table('bonds', function (Blueprint $table) {
            $table->dropColumn('reference_number');
        });

        Schema::table('shares', function (Blueprint $table) {
            $table->dropColumn('reference_number');
        });
    }
}
