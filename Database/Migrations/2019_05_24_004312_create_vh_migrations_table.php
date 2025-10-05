<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVhMigrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('vh_migrations')) {
            Schema::create('vh_migrations', function (Blueprint $table) {

                $table->increments('id');
                $table->integer('migrationable_id')->nullable();
                $table->string('migrationable_type')->nullable();

                $table->integer('migration_id')->nullable();
                $table->integer('batch')->nullable();

                $table->timestamps();

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
        Schema::dropIfExists('vh_migrations');
    }
}
