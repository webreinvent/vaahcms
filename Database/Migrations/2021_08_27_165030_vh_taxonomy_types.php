<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VhTaxonomyTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vh_taxonomy_types', function (Blueprint $table) {

            $table->increments('id');
            $table->uuid('uuid')->nullable()->index();
            $table->integer('parent_id')->nullable()->index();
            $table->string('name')->nullable()->index();
            $table->string('slug')->nullable()->index();

            $table->boolean('is_active')->nullable()->index();

            //----common fields
            $table->text('meta')->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable()->index();
            $table->foreign('created_by')->references('id')->on('vh_users');
            $table->bigInteger('updated_by')->unsigned()->nullable()->index();
            $table->foreign('updated_by')->references('id')->on('vh_users');
            $table->bigInteger('deleted_by')->unsigned()->nullable()->index();
            $table->foreign('deleted_by')->references('id')->on('vh_users');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['created_at', 'updated_at', 'deleted_at']);
            //----/common fields

        });

        /*Schema::table('vh_taxonomy_types',function (Blueprint $table){
            $table->foreign('parent_id')->references('id')->on('vh_taxonomy_types');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vh_taxonomy_types');
    }
}
