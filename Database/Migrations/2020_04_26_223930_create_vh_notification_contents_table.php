<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVhNotificationContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('vh_notification_contents', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->bigInteger('vh_notification_id')->unsigned()->nullable()->index();
            $table->foreign('vh_notification_id')->references('id')->on('vh_notifications');

            $table->string('via')->nullable()->index();

            $table->integer('sort')->nullable();

            $table->string('key')->nullable()->index();
            $table->text('value')->nullable();
            $table->json('meta')->nullable();

            $table->bigInteger('created_by')->unsigned()->nullable()->index();
            $table->foreign('created_by')->references('id')->on('vh_users');
            $table->bigInteger('updated_by')->unsigned()->nullable()->index();
            $table->foreign('updated_by')->references('id')->on('vh_users');
            $table->bigInteger('deleted_by')->unsigned()->nullable()->index();
            $table->foreign('deleted_by')->references('id')->on('vh_users');

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
        Schema::dropIfExists('vh_notification_contents');
    }
}
