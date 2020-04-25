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
            $table->increments('id');

            $table->string('name')->nullable()->index();
            $table->uuid('uuid')->nullable();
            $table->string('original_name')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('extension')->nullable();
            $table->string('path')->nullable();
            $table->string('url')->nullable();
            $table->string('url_thumbnail')->nullable();
            $table->integer('size')->nullable();
            $table->string('title')->nullable();
            $table->string('caption')->nullable();
            $table->string('alt_text')->nullable();
            $table->boolean('is_hidden')->nullable();
            $table->string('download_url')->nullable();
            $table->boolean('download_requires_login')->nullable();
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
        Schema::dropIfExists('vh_medias');
    }
}
