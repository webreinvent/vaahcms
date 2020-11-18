<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVhThemeTemplateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('vh_theme_template_fields', function (Blueprint $table) {
            $table->increments('id');

            $table->uuid('uuid')->nullable();
            $table->integer('vh_theme_id')->nullable();
            $table->integer('vh_template_id')->nullable();
            $table->integer('sort')->nullable();

            $table->string('name')->nullable();
            $table->string('slug')->nullable();

            $table->string('type')->nullable(); // editor, json, slug

            $table->string('content')->nullable();
            $table->string('excerpt')->nullable();

            $table->boolean('is_searchable')->nullable();
            $table->boolean('is_repeatable')->nullable();

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
        Schema::dropIfExists('vh_theme_template_fields');
    }
}
