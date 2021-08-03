<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVhNotifiedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('vh_notified', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->bigInteger('vh_notification_id')->unsigned()->nullable()->index();
            $table->foreign('vh_notification_id')->references('id')->on('vh_notifications');

            $table->bigInteger('vh_user_id')->unsigned()->nullable()->index();
            $table->foreign('vh_user_id')->references('id')->on('vh_users');

            $table->string('via')->nullable()->index();

            $table->dateTime('last_attempt_at')->nullable();
            $table->dateTime('sent_at')->nullable()->index();
            $table->dateTime('read_at')->nullable()->index();
            $table->dateTime('marked_delivered')->nullable()->index();

            $table->json('meta')->nullable();

            $table->timestamps();
            $table->softDeletes();


            $table->index(['created_at', 'updated_at', 'deleted_at']);

        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('vh_notified');
    }
}
