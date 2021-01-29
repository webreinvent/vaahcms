<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVhUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vh_users', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->nullable()->index();
            $table->string('email',150)->nullable()->index();
            $table->string('username',150)->nullable()->index();
            $table->string('password')->nullable()->index();
            $table->string('display_name',50)->nullable();
            $table->string('title',200)->nullable();
            $table->string('first_name',150)->nullable()->index();
            $table->string('middle_name')->nullable()->index();
            $table->string('last_name',150)->nullable()->index();
            $table->string('gender', 15)->nullable();
            $table->integer('country_calling_code')->nullable();
            $table->bigInteger('phone')->nullable()->index();
            $table->mediumText('bio')->nullable();
            $table->string('website')->nullable();
            $table->string('timezone')->nullable();
            $table->string('alternate_email')->nullable();
            $table->string('avatar_url')->nullable();
            $table->date('birth')->nullable();
            $table->string('country')->nullable();
            $table->string('country_code')->nullable();
            $table->dateTime('last_login_at')->nullable();
            $table->ipAddress('last_login_ip')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('api_token')->nullable()->index();
            $table->dateTime('api_token_used_at')->nullable();
            $table->ipAddress('api_token_used_ip')->nullable();
            $table->boolean('is_active')->nullable()->index();
            $table->dateTime('activated_at')->nullable();
            $table->string('status')->nullable()->index();
            $table->string('affiliate_code')->nullable();
            $table->dateTime('affiliate_code_used_at')->nullable();

            $table->string('reset_password_code')->nullable();
            $table->dateTime('reset_password_code_sent_at')->nullable();
            $table->dateTime('reset_password_code_used_at')->nullable();

            $table->integer('registration_id')->nullable()->index();
            $table->text('meta')->nullable();

            $table->ipAddress('created_ip')->nullable();

            $table->integer('created_by')->nullable()->index();
            $table->integer('updated_by')->nullable()->index();
            $table->integer('deleted_by')->nullable()->index();
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
        Schema::dropIfExists('vh_users');
    }
}
