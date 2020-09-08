<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableShareAddShareTypeId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shares', function (Blueprint $table) {
            $table->integer('share_type_id'); //from constants
            $table->dropColumn('sales_kitta');

            $table->dropForeign(['institution_id']);
            $table->dropColumn('institution_id');

            $table->string('institution_code', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shares', function (Blueprint $table) {
            $table->dropColumn('share_type_id');
            $table->integer('sales_kitta')->nullable();

            $table->unsignedInteger('institution_id')->nullable();
            $table->foreign('institution_id')
                ->references('id')->on('investment_institutions')
                ->onDelete('cascade');

            $table->dropColumn('institution_code');
        });
    }
}
