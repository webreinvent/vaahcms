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
            $table->increments('id');

            $table->integer('vh_notification_id')->nullable()->index();

            $table->string('via')->nullable()->index();

            $table->integer('sort')->nullable();

            $table->string('key')->nullable()->index();
            $table->text('value')->nullable();
            $table->json('meta')->nullable();

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();

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
        Schema::dropIfExists('vh_notification_contents');
    }
}
