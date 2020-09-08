<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUserOrganizationsAddDepsoitExcelColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_organizations', function (Blueprint $table) {
            $table->text('deposit_excel_columns')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_organizations', function (Blueprint $table) {
            $table->dropColumn('deposit_excel_columns')->nullable();
        });
    }
}
