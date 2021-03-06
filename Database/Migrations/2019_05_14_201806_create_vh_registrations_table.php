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
            $table->integer('invited_by')->nullable()->index();
            $table->dateTime('invited_at')->nullable();

            $table->string('invited_for_key')->nullable()->index();
            $table->string('invited_for_value')->nullable();

            $table->nullableMorphs('belong');

            $table->integer('vh_user_id')->nullable()->index();
            $table->dateTime('user_created_at')->nullable();
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
        Schema::dropIfExists('vh_registrations');
    }
}
