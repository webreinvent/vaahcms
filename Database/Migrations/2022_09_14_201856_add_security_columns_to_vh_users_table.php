<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSecurityColumnsToVhUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vh_users', function (Blueprint $table) {
            $table->text('mfa_methods')->after('country_code')
                ->nullable();
            $table->string('security_code',50)->after('status')
                ->nullable();
            $table->dateTime('security_code_expired_at')->after('security_code')
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
            $table->dropColumn('security_code');
            $table->dropColumn('security_code_expired_at');
        });
    }
}
