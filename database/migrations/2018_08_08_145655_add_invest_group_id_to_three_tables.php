<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvestGroupIdToThreeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('bonds', function (Blueprint $table) {
		    $table->unsignedInteger('invest_group_id')->nullable()->after('status');
	    });
	
	    Schema::table('shares', function (Blueprint $table) {
		    $table->unsignedInteger('invest_group_id')->nullable()->after('status');
	    });
	
	    Schema::table('deposits', function (Blueprint $table) {
		    $table->unsignedInteger('invest_group_id')->nullable()->after('status');
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
            $table->dropColumn('invest_group_id');
        });

        Schema::table('shares', function (Blueprint $table) {
            $table->dropColumn('invest_group_id');
        });

        Schema::table('deposits', function (Blueprint $table) {
            $table->dropColumn('invest_group_id');
        });
    }
}
