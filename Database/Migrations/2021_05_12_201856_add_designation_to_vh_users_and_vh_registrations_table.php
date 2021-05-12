<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDesignationToVhUsersAndVhRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vh_users', function (Blueprint $table) {
            $table->string('designation',200)->after('title')
                ->nullable()->index();
        });
        Schema::table('vh_registrations', function (Blueprint $table) {
            $table->string('designation',200)->after('title')
                ->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vh_users', function (Blueprint $table) {
            $table->dropColumn('designation');
        });
        Schema::table('vh_registrations', function (Blueprint $table) {
            $table->dropColumn('designation');
        });
    }
}
