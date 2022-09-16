<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMfaColumnsToVhUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vh_users', function (Blueprint $table) {
            $table->string('mfa_methods')->after('country_code')
                ->nullable();
            $table->string('mfa_code',50)->after('status')
                ->nullable();
            $table->dateTime('mfa_code_expired_at')->after('mfa_code')
                ->nullable();
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
            $table->dropColumn('mfa_methods');
            $table->dropColumn('mfa_code');
            $table->dropColumn('mfa_code_expired_at');
        });
    }
}
