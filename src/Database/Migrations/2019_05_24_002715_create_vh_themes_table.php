<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVhThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vh_themes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('excerpt')->nullable();
            $table->string('description')->nullable();
            $table->string('github_url')->nullable();
            $table->string('author_name')->nullable();
            $table->string('author_website')->nullable();
            $table->string('version')->nullable();
            $table->integer('version_number')->nullable();
            $table->boolean('is_sample_data_available')->nullable();
            $table->boolean('is_update_available')->nullable();
            $table->dateTime('update_checked_at')->nullable();

            $table->boolean('is_active')->nullable();

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
        Schema::dropIfExists('vh_themes');
    }
}
