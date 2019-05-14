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
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('authorization_id')->nullable();
            $table->dateTime('last_authorization_at')->nullable();
            $table->text('meta')->nullable();

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
        Schema::dropIfExists('vh_user_authorizations');
    }
}
