<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVhRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vh_registrations', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->uuid('uuid')->nullable()->index();
            $table->string('email',150)->nullable()->index();
            $table->string('username',150)->nullable()->index();
            $table->string('password')->nullable();
            $table->string('display_name',50)->nullable()->index();
            $table->string('title',200)->nullable();
            $table->string('first_name',150)->nullable()->index();
            $table->string('middle_name')->nullable()->index();
            $table->string('last_name',150)->nullable()->index();
            $table->string('gender', 15)->nullable();
            $table->integer('country_calling_code')->nullable();
            $table->bigInteger('phone')->nullable()->index();
            $table->string('timezone')->nullable();
            $table->string('alternate_email')->nullable();
            $table->string('avatar_url')->nullable();
            $table->date('birth')->nullable();
            $table->string('country')->nullable();
            $table->string('country_code')->nullable();
            $table->string('status')->nullable()->index();
            $table->string('activation_code')->nullable()->index();
            $table->dateTime('activation_code_sent_at')->nullable();
            $table->dateTime('activated_at')->nullable();
            $table->ipAddress('activated_ip')->nullable();

            $table->bigInteger('invited_by')->unsigned()->nullable()->index();
            $table->foreign('invited_by')->references('id')->on('vh_users');

            $table->dateTime('invited_at')->nullable();

            $table->string('invited_for_key')->nullable()->index();
            $table->string('invited_for_value')->nullable();

            $table->nullableMorphs('belong');

            $table->bigInteger('vh_user_id')->unsigned()->nullable()->index();
            $table->foreign('vh_user_id')->references('id')->on('vh_users');

            $table->dateTime('user_created_at')->nullable();
            $table->text('meta')->nullable();

            $table->ipAddress('created_ip')->nullable();

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


        Schema::table('vh_users',function (Blueprint $table){
            $table->foreign('registration_id')->references('id')->on('vh_registrations');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        if (Schema::hasTable('vh_users')) {
            Schema::table('vh_users', function (Blueprint $table) {
                $table->dropForeign(['registration_id']);
            });
        }

        Schema::dropIfExists('vh_registrations');
    }
}
