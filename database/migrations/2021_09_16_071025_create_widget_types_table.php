<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWidgetTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widget_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('category');
            $table->string('name');
            $table->string('type', 50);
            $table->tinyText('icon');
            $table->text('settings')->nullable();
            $table->text('configurations')->nullable();
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('widget_types');
    }
}
