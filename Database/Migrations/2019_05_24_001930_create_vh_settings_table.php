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

            $table->timestamps();

            $table->index(['created_at', 'updated_at']);

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
