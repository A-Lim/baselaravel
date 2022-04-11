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
        Schema::create('announcements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('description');
            $table->string('audience');
            $table->bigInteger('audience_data_id')->nullable();
            $table->boolean('has_content')->default(false);
            $table->text('content')->nullable();
            $table->string('status', 50);
            $table->boolean('push_notification')->default(false);
            $table->boolean('notification_sent')->default(false);
            $table->date('scheduled_publish_date')->nullable();
            $table->datetime('published_at')->nullable();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned()->nullable();
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
        Schema::dropIfExists('announcements');
    }
};
