<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTdsToUserOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_organizations', function (Blueprint $table) {
            $table->mediumText('tds_certification_letter')->nullable();
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
            $table->dropColumn('tds_certification_letter');
        });
    }
}
