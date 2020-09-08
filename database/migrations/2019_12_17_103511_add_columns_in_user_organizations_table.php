<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInUserOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_organizations', function (Blueprint $table) {
            $table->mediumText('placement_letter')->nullable();;
            $table->mediumText('placement_letter2')->nullable();
            $table->mediumText('renew_letter')->nullable();
            $table->mediumText('withdraw_letter')->nullable();
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
            $table->dropColumn('placement_letter');
            $table->dropColumn('placement_letter2');
            $table->dropColumn('renew_letter');
            $table->dropColumn('withdraw_letter');
        });
    }
}
