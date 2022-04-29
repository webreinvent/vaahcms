<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VhSettingsAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('vh_settings', function (Blueprint $table) {

            $table->uuid('uuid')->nullable()->index();

            $table->bigInteger('vh_user_id')->after('meta')
                ->unsigned()->nullable()->index();
            $table->foreign('vh_user_id')
                ->references('id')->on('vh_users');
            $table->bigInteger('created_by')->after('vh_user_id')
                ->unsigned()->nullable()->index();
            $table->foreign('created_by')
                ->references('id')->on('vh_users');

            $table->bigInteger('updated_by')->after('created_by')
                ->unsigned()->nullable()->index();
            $table->foreign('updated_by')
                ->references('id')->on('vh_users');

            $table->bigInteger('deleted_by')->after('updated_by')
                ->unsigned()->nullable()->index();
            $table->foreign('deleted_by')
                ->references('id')->on('vh_users');

            $table->softDeletes()->after('updated_at');
            $table->index(['deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vh_settings', function (Blueprint $table) {
            $table->dropColumn('vh_user_id');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
            $table->dropColumn('deleted_by');
            $table->dropSoftDeletes();
        });
    }
}
