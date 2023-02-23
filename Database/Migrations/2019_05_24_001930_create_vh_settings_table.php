<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVhSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('vh_settings')) {
            Schema::create('vh_settings', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();

                $table->integer('settingable_id')->nullable()->index();
                $table->string('settingable_type')->nullable()->index();

                $table->string('category')->nullable()->index();

                $table->string('label')->nullable();
                $table->string('excerpt')->nullable();
                $table->string('type')->nullable()->index();
                $table->string('key')->nullable()->index();
                $table->text('value')->nullable();
                $table->json('meta')->nullable();
                $table->bigInteger('vh_user_id')->unsigned()->nullable()->index();
                $table->bigInteger('vh_user_id')->unsigned()
                    ->nullable()->index();
                $table->foreign('vh_user_id')
                    ->references('id')->on('vh_users');
                $table->bigInteger('created_by')
                    ->unsigned()->nullable()->index();
                $table->foreign('created_by')
                    ->references('id')->on('vh_users');

                $table->bigInteger('updated_by')
                    ->unsigned()->nullable()->index();
                $table->foreign('updated_by')
                    ->references('id')->on('vh_users');

                $table->bigInteger('deleted_by')
                    ->unsigned()->nullable()->index();
                $table->foreign('deleted_by')
                    ->references('id')->on('vh_users');

                $table->softDeletes();
                $table->index(['deleted_at']);


                $table->timestamps();

                $table->index(['created_at', 'updated_at']);
                $table->softDeletes();

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
        Schema::dropIfExists('vh_settings');
    }
}
