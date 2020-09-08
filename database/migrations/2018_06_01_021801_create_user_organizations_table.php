<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('organization_name',100);
            $table->string('address',100);
            $table->string('contact_person',100);
            $table->string('effect_date',10);
            $table->date('effect_date_en');
            $table->string('valid_date',10);
            $table->date('valid_date_en');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_organizations');
    }
}
