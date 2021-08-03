<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVhMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('vh_medias', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->string('name',150)->nullable()->index();
            $table->string('slug',150)->nullable()->index();
            $table->uuid('uuid')->nullable()->index();
            $table->string('original_name')->nullable()->index();
            $table->string('mime_type')->nullable();
            $table->string('extension')->nullable();
            $table->string('path')->nullable();
            $table->string('url')->nullable();
            $table->string('url_thumbnail')->nullable();
            $table->integer('size')->nullable();
            $table->string('title',200)->nullable()->index();
            $table->string('caption')->nullable()->index();
            $table->string('alt_text')->nullable();
            $table->boolean('is_hidden')->nullable();
            $table->boolean('is_downloadable')->nullable()->index();
            $table->string('download_url')->nullable();
            $table->boolean('download_requires_login')->nullable()->index();
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
        Schema::dropIfExists('vh_medias');
    }
}
