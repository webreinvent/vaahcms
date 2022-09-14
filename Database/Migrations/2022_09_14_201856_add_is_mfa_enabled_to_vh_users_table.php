<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsMfaEnabledToVhUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vh_users', function (Blueprint $table) {
            $table->boolean('is_mfa_enabled')->after('country_code')
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
            $table->dropColumn('is_mfa_enabled');
        });
    }
}
