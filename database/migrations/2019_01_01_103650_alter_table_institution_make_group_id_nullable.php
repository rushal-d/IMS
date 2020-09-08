<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableInstitutionMakeGroupIdNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investment_institutions', function (Blueprint $table) {
            $table->unsignedInteger('invest_group_id')->nullable()->change();
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
            $table->unsignedInteger('invest_group_id')->nullable(false)->change();
        });
    }
}
