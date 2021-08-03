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
            $table->bigIncrements('id')->unsigned();
            $table->string('name',150)->nullable();
            $table->string('title',200)->nullable();
            $table->string('slug',150)->nullable()->index();
            $table->string('thumbnail')->nullable();
            $table->string('excerpt')->nullable();
            $table->string('description')->nullable();
            $table->string('download_link')->nullable();
            $table->string('author_name')->nullable();
            $table->string('author_website')->nullable();
            $table->string('vaah_url')->nullable();
            $table->string('version')->nullable();
            $table->integer('version_number')->nullable();
            $table->string('db_table_prefix')->nullable();
            $table->boolean('is_migratable')->nullable();
            $table->boolean('is_default')->nullable()->index();
            $table->boolean('is_sample_data_available')->nullable();
            $table->boolean('is_update_available')->nullable();
            $table->boolean('is_assets_published')->nullable();
            $table->dateTime('update_checked_at')->nullable();
            $table->boolean('is_active')->nullable()->index();

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
        Schema::dropIfExists('vh_themes');
    }
}
