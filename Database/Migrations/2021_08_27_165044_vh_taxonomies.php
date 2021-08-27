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
            $table->integer('parent_id')->nullable()->index();
            $table->string('type')->nullable()->index();
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
            $table->integer('created_by')->nullable()->index();
            $table->integer('updated_by')->nullable()->index();
            $table->integer('deleted_by')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['created_at', 'updated_at', 'deleted_at']);
            //----/common fields

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
