<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVhLangStringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('vh_lang_strings', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->bigInteger('vh_lang_language_id')->unsigned()->nullable()->index();
            $table->foreign('vh_lang_language_id')->references('id')->on('vh_lang_languages');

            $table->bigInteger('vh_lang_category_id')->unsigned()->nullable()->index();
            $table->foreign('vh_lang_category_id')->references('id')->on('vh_lang_categories');

            $table->string('name',150)->nullable();
            $table->string('slug',150)->nullable()->index();
            $table->mediumText('content')->nullable();


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

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('vh_lang_strings');
    }
}
