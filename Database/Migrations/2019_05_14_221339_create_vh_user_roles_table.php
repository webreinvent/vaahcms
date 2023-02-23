<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVhUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('vh_user_roles')) {
            Schema::create('vh_user_roles', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();

                $table->bigInteger('vh_user_id')->unsigned()->nullable()->index();
                $table->foreign('vh_user_id')->references('id')->on('vh_users');
                $table->bigInteger('vh_role_id')->unsigned()->nullable()->index();
                $table->foreign('vh_role_id')->references('id')->on('vh_roles');

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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vh_user_roles');
    }
}
