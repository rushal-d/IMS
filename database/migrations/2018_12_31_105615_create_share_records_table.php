<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShareRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('organization_name')->nullable();
            $table->string('organization_code')->nullable();
            $table->double('closing_value')->nullable();
            $table->date('date')->nullable();
            $table->string('date_np')->nullable();
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
        Schema::dropIfExists('share_records');
    }
}
