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

            $table->integer('vh_notification_id')->nullable()->index();
            $table->integer('vh_user_id')->nullable()->index();
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
