<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_setups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('driver')->nullable();
            $table->string('host');
            $table->string('port');
            $table->string('from_address');
            $table->string('from_name');
            $table->string('encryption');
            $table->string('username');
            $table->string('password');
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
        Schema::dropIfExists('email_setups');
    }
}
