<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeletedByIdToBondsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bonds', function (Blueprint $table) {
            $table->unsignedInteger('deleted_by_id')->nullable();
            $table->foreign('deleted_by_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bonds', function (Blueprint $table) {
            $table->dropForeign(['deleted_by_id']);
            $table->dropColumn('deleted_by_id');
        });
    }
}
