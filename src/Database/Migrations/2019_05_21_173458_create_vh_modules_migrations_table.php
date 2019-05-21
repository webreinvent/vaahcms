<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVhModulesMigrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vh_modules_migrations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('migration_id')->nullable();
            $table->integer('module_id')->nullable();
            $table->string('module_slug')->nullable();
            $table->integer('batch')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vh_modules_migrations');
    }
}
