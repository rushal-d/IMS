<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvestmentGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investment_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('group_name');
            $table->unsignedInteger('parent_id')->nullable();
            $table->float('percentage')->nullable();
            $table->string('description')->nullable();
            $table->unsignedInteger('invest_type_id');
            $table->timestamps();

            $table->foreign('invest_type_id')
                ->references('id')->on('investment_types')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('investment_groups');
    }
}
