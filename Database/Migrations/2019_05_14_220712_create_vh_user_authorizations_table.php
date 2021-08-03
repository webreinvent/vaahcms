<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVhUserAuthorizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vh_user_authorizations', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->bigInteger('vh_user_id')->unsigned()->nullable();
            $table->foreign('vh_user_id')->references('id')->on('vh_users');

            $table->string('name',150)->nullable();
            $table->string('slug',150)->nullable();
            $table->string('authorization_id')->nullable();
            $table->dateTime('last_authorization_at')->nullable();
            $table->text('meta')->nullable();

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
        Schema::dropIfExists('vh_user_authorizations');
    }
}
