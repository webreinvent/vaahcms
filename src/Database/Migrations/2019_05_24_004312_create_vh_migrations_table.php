<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVhMigrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vh_migrations', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('migrationable_id')->nullable();
            $table->string('migrationable_type')->nullable();

            $table->integer('migration_id')->nullable();
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
        Schema::dropIfExists('vh_migrations');
    }
}
