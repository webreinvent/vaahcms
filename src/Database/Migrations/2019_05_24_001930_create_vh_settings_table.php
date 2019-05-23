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
        Schema::create('vh_settings', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('settingable_id')->nullable();
            $table->string('settingable_type')->nullable();

            $table->string('label')->nullable();
            $table->string('excerpt')->nullable();
            $table->string('type')->nullable();
            $table->string('key')->nullable();
            $table->text('value')->nullable();
            $table->timestamps();

        });
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
