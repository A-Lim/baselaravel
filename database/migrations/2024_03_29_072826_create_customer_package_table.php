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
        Schema::create('customer_package', function (Blueprint $table) {
            $table->id();
            $table->integer('count');
            $table->decimal('price');
            $table->date('purchased_date');
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers')
                  ->onDelete('cascade');

            $table->foreign('package_id')
                  ->references('id')
                  ->on('packages')
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
        Schema::dropIfExists('customer_package');
    }
};
