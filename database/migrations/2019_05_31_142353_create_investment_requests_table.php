<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvestmentRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investment_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->date('request_date_en')->nullable();
            $table->text('request_date')->nullable();
            $table->unsignedInteger('institution_id')->nullable();
            $table->integer('days')->nullable();
            $table->string('interest_payment_method')->nullable();
            $table->decimal('deposit_amount', 40, 2)->nullable();
            $table->decimal('interest_rate', 4, 2)->nullable();
            $table->unsignedInteger('branch_id')->nullable();
            $table->unsignedInteger('organization_branch_id')->nullable();
            $table->unsignedInteger('staff_id')->nullable();
            $table->integer('status')->nullable();
            $table->unsignedInteger('created_by_id')->nullable();
            $table->unsignedInteger('updated_by_id')->nullable();
            $table->text('remarks')->nullable();

            $table->foreign('institution_id')
                ->references('id')->on('investment_institutions')
                ->onDelete('cascade');

            $table->foreign('created_by_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('updated_by_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('branch_id')->references('id')->on('bank_branches');
            $table->foreign('staff_id')->references('id')->on('staff');

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
        Schema::dropIfExists('investment_requests');
    }
}
