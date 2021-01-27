<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVhNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('vh_notifications', function (Blueprint $table) {
            $table->increments('id');

            $table->uuid('uuid')->nullable();

            $table->string('name',150)->nullable()->index();
            $table->string('slug',150)->nullable()->index();

            $table->string('details',255)->nullable();

            $table->boolean('via_mail')->nullable()->index();
            $table->boolean('via_sms')->nullable()->index();
            $table->boolean('via_push')->nullable()->index();
            $table->boolean('via_frontend')->nullable()->index();
            $table->boolean('via_backend')->nullable()->index();
            $table->boolean('is_error')->nullable();
            $table->boolean('can_update_via')->nullable();


            $table->integer('created_by')->nullable()->index();
            $table->integer('updated_by')->nullable()->index();
            $table->integer('deleted_by')->nullable()->index();
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
        Schema::dropIfExists('vh_notifications');
    }
}
