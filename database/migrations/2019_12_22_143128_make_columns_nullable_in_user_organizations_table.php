<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeColumnsNullableInUserOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_organizations', function (Blueprint $table) {
            $table->string('address')->nullable()->change();
            $table->string('contact_person')->nullable()->change();
            $table->string('effect_date')->nullable()->change();
            $table->string('effect_date_en')->nullable()->change();
            $table->string('valid_date')->nullable()->change();
            $table->date('valid_date_en')->nullable()->change();
            $table->boolean('status')->nullable()->change();
            $table->boolean('implement_merger')->nullable()->change();
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
            //
        });
    }
}
