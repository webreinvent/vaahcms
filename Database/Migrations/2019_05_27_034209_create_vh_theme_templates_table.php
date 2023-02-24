<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVhThemeTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('vh_theme_templates')) {
            Schema::create('vh_theme_templates', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->integer('vh_theme_id')->nullable()->index();
                $table->string('type')->nullable()->index();
                $table->string('name',150)->nullable();
                $table->string('slug',150)->nullable()->index();
                $table->string('file_path')->nullable()->index();
                $table->string('excerpt')->nullable();
                $table->timestamps();
                $table->index(['created_at', 'updated_at']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vh_theme_templates');
    }
}
