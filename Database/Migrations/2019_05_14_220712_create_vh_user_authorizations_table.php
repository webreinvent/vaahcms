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
            $table->increments('id');

            $table->integer('vh_user_id')->nullable();
            $table->string('name',150)->nullable();
            $table->string('slug',150)->nullable();
            $table->string('authorization_id')->nullable();
            $table->dateTime('last_authorization_at')->nullable();
            $table->text('meta')->nullable();

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
        Schema::dropIfExists('vh_user_authorizations');
    }
}
