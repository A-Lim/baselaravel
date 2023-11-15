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
        Schema::create('widgets', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('dashboard_id');
            $table->string('category');
            $table->string('name');
            $table->string('type', 50);
            $table->text('settings')->nullable();
            $table->integer('x');
            $table->integer('y');
            $table->integer('rows');
            $table->integer('cols');
            $table->boolean('dragEnabled')->default(true);
            $table->boolean('resizeEnabled')->default(true);
            $table->boolean('compactEnabled')->default(true);
            $table->integer('maxItemRows')->nullable();
            $table->integer('minItemRows')->nullable();
            $table->integer('maxItemCols')->nullable();
            $table->integer('minItemCols')->nullable();
            $table->integer('minItemArea')->nullable();
            $table->integer('maxItemArea')->nullable();

            $table->foreign('dashboard_id')
                  ->references('id')
                  ->on('dashboards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('widgets');
    }
};
