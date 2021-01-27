<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVhLangLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('vh_lang_languages', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name',150)->nullable();
            $table->string('locale_code_iso_639')->nullable()->index();
            $table->boolean('right_to_left')->nullable()->default(0);
            $table->boolean('default')->nullable()->default(0);
            $table->integer('count_strings')->nullable()->default(0);
            $table->integer('count_strings_filled')->nullable()->default(0);

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
        Schema::dropIfExists('vh_lang_languages');
    }
}
