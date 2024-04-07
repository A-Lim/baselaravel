<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customerpackage_transaction', function (Blueprint $table) {
            $table->unsignedBigInteger('customerpackage_id');
            $table->unsignedBigInteger('transaction_id');
            $table->decimal('amount');

            $table->foreign('customerpackage_id')
                  ->references('id')
                  ->on('customer_package')
                  ->onDelete('cascade');

            $table->foreign('transaction_id')
                  ->references('id')
                  ->on('transactions')
                  ->onDelete('cascade');
            $table->primary(['customerpackage_id', 'transaction_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customerpackage_transaction');
    }
};
