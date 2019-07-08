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
            $table->increments('id');

            $table->string('uid')->nullable();
            $table->string('email')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('display_name')->nullable();
            $table->string('title', 5)->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('gender', 15)->nullable();
            $table->integer('country_calling_code')->nullable();
            $table->bigInteger('phone')->nullable();
            $table->string('timezone')->nullable();
            $table->string('alternate_email')->nullable();
            $table->string('avatar_url')->nullable();
            $table->date('birth')->nullable();
            $table->string('country')->nullable();
            $table->string('country_code')->nullable();

            $table->string('status')->nullable();

            $table->string('activation_code')->nullable();
            $table->dateTime('activation_code_sent_at')->nullable();
            $table->dateTime('activated_at')->nullable();
            $table->ipAddress('activated_ip')->nullable();
            $table->integer('invited_by')->nullable();
            $table->dateTime('invited_at')->nullable();

            $table->integer('user_id')->nullable();
            $table->dateTime('user_created_at')->nullable();
            $table->text('meta')->nullable();

            $table->ipAddress('created_ip')->nullable();

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
        Schema::dropIfExists('vh_users_temporary');
    }
}
