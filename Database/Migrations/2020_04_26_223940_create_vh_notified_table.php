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
            $table->increments('id');

            $table->integer('vh_notification_id')->nullable();
            $table->integer('vh_user_id')->nullable();
            $table->string('via')->nullable();

            $table->dateTime('last_attempt_at')->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->dateTime('read_at')->nullable();
            $table->dateTime('marked_delivered')->nullable();

            $table->json('meta')->nullable();

            $table->timestamps();
            $table->softDeletes();

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
