<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableDepositAddIsPending extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->date('cheque_date')->nullable();
            $table->text('cheque_date_np')->nullable();
            $table->longText('narration')->nullable();
            $table->string('voucher_number')->nullable();
            $table->boolean('is_pending')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropColumn('cheque_date');
            $table->dropColumn('cheque_date_np');
            $table->dropColumn('narration');
            $table->dropColumn('voucher_number');
            $table->dropColumn('is_pending');
        });
    }
}
