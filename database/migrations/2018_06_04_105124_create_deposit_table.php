<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fiscal_year_id')->nullable();
            $table->string('trans_date')->nullable();
            $table->date('trans_date_en')->nullable();
            $table->unsignedInteger('institution_id')->nullable();
            $table->unsignedInteger('investment_subtype_id')->nullable();
            $table->integer('days')->nullable();
            $table->string('mature_date')->nullable();
            $table->date('mature_date_en')->nullable();
            $table->string('document_no',30)->nullable();
            $table->string('interest_payment_method')->nullable();
            $table->boolean('loan_or_premature')->nullable();
            $table->decimal('deposit_amount',40,2)->nullable();
            $table->decimal('interest_rate',4,2)->nullable();
            $table->decimal('estimated_earning',20,2)->nullable();
            $table->mediumInteger('alert_days')->nullable();
            $table->integer('expiry_days')->nullable();
            $table->unsignedInteger('created_by_id')->nullable();
            $table->unsignedInteger('updated_by_id')->nullable();
            $table->boolean('status')->nullable();
            $table->timestamps();

            $table->foreign('fiscal_year_id')
                ->references('id')->on('fiscal_years')
                ->onDelete('cascade');

            $table->foreign('institution_id')
                ->references('id')->on('investment_institutions')
                ->onDelete('cascade');

            $table->foreign('investment_subtype_id')
                ->references('id')->on('investment_sub_types')
                ->onDelete('cascade');

            $table->foreign('created_by_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('updated_by_id')
                ->references('id')->on('users')
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
        Schema::dropIfExists('deposits');
    }
}
