<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VhTaxonomies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vh_taxonomies', function (Blueprint $table) {

            $table->increments('id');
            $table->uuid('uuid')->nullable()->index();
            $table->integer('parent_id')->unsigned()->nullable()->index();
            $table->integer('vh_taxonomy_type_id')->unsigned()->nullable()->index();
            $table->foreign('vh_taxonomy_type_id')->references('id')->on('vh_taxonomy_types');
            $table->string('name')->nullable()->index();
            $table->string('slug')->nullable()->index();

            $table->mediumText('excerpt')->nullable();
            $table->mediumText('details')->nullable();
            $table->text('notes')->nullable();

            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();

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

        Schema::table('vh_taxonomies',function (Blueprint $table){
            $table->foreign('parent_id')->references('id')->on('vh_taxonomies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vh_taxonomies');
    }
}
