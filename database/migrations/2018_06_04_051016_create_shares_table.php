<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shares', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fiscal_year_id')->nullable();
            $table->string('trans_date')->nullable();
            $table->date('trans_date_en')->nullable();
            $table->unsignedInteger('institution_id')->nullable();
            $table->unsignedInteger('investment_subtype_id')->nullable();
            $table->integer('sales_kitta')->nullable();
            $table->integer('purchase_kitta')->nullable();
            $table->string('kitta_details',300)->nullable();
            $table->decimal('purchase_value',20,10)->nullable();
            $table->decimal('total_amount',30,10)->nullable();
            $table->decimal('closing_value',30,10)->nullable();
//            $table->decimal('estimated_earning',20,2);
//            $table->mediumInteger('alert_days');
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
        Schema::dropIfExists('shares');
    }
}
