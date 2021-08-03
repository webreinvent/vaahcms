<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVhPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vh_permissions', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->uuid('uuid')->nullable();
            $table->string('name',150)->nullable();
            $table->string('slug',150)->nullable()->index();

            $table->string('module')->nullable();
            $table->string('section')->nullable();

            $table->string('details',255)->nullable();
            $table->integer('count_users')->nullable();
            $table->integer('count_roles')->nullable();
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
        Schema::dropIfExists('vh_permissions');
    }
}
