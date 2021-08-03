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
            $table->bigIncrements('id')->unsigned();
            $table->uuid('uuid')->nullable()->index();
            $table->string('email',150)->nullable()->index();
            $table->string('username',150)->nullable()->index();
            $table->string('password')->nullable()->index();
            $table->string('display_name',50)->nullable()->comment("If filled this will be visible as user's name.");
            $table->string('title',200)->nullable();
            $table->string('first_name',150)->nullable()->index();
            $table->string('middle_name')->nullable()->index();
            $table->string('last_name',150)->nullable()->index();
            $table->string('gender', 15)->nullable();
            $table->integer('country_calling_code')->nullable();
            $table->bigInteger('phone')->nullable()->index();
            $table->mediumText('bio')->nullable()->comment("Short bio of the user.");
            $table->string('website')->nullable();
            $table->string('timezone')->nullable()->comment("Timezone of the user");
            $table->string('alternate_email')->nullable();
            $table->string('avatar_url')->nullable();
            $table->date('birth')->nullable();
            $table->string('country')->nullable();
            $table->string('country_code')->nullable()->comment("Country short code");
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

            $table->bigInteger('registration_id')->unsigned()->nullable()->index();
            $table->text('meta')->nullable();

            $table->ipAddress('created_ip')->nullable();

            $table->bigInteger('created_by')->unsigned()->nullable()->index();
            $table->bigInteger('updated_by')->unsigned()->nullable()->index();
            $table->bigInteger('deleted_by')->unsigned()->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['created_at', 'updated_at', 'deleted_at']);
        });


        Schema::table('vh_users',function (Blueprint $table){
            $table->foreign('created_by')->references('id')->on('vh_users');
            $table->foreign('updated_by')->references('id')->on('vh_users');
            $table->foreign('deleted_by')->references('id')->on('vh_users');
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
