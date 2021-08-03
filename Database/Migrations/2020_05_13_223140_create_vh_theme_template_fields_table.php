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
            $table->bigIncrements('id')->unsigned();

            $table->uuid('uuid')->nullable();
            $table->integer('vh_theme_id')->nullable()->index();
            $table->integer('vh_template_id')->nullable()->index();
            $table->integer('sort')->nullable()->index();

            $table->string('name')->nullable();
            $table->string('slug')->nullable()->index();

            $table->string('type')->nullable()->index(); // editor, json, slug

            $table->string('content')->nullable();
            $table->string('excerpt')->nullable();

            $table->boolean('is_searchable')->nullable()->index();
            $table->boolean('is_repeatable')->nullable()->index();

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
        Schema::dropIfExists('vh_theme_template_fields');
    }
}
