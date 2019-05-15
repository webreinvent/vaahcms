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
            $table->increments('id');

            $table->string('uid')->nullable();
            $table->string('slug')->nullable();
            $table->string('module')->nullable();
            $table->string('section')->nullable();
            $table->string('name')->nullable();
            $table->string('label')->nullable();
            $table->string('details')->nullable();
            $table->integer('count_users')->nullable();
            $table->integer('count_roles')->nullable();
            $table->boolean('is_active')->nullable();
            $table->dateTime('synced_at')->nullable();

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
        Schema::dropIfExists('vh_permissions');
    }
}
