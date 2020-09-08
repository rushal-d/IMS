<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_books', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fiscal_year_id');
            $table->foreign('fiscal_year_id')
                ->references('id')->on('fiscal_years')
                ->onDelete('cascade');
            $table->date('date_en');
            $table->string('date');
            $table->double('amount')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedInteger('organization_branch_id');
            $table->foreign('organization_branch_id')
                ->references('id')->on('organization_branches')
                ->onDelete('cascade');
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
        Schema::dropIfExists('business_books');
    }
}
