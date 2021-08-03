<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VhUsersAddForeignUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('vh_users', function (Blueprint $table) {
            $table->bigInteger('foreign_user_id')->after('registration_id')
                ->nullable()->index()->comment("Column can be used to map users from foreign database.");
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
            $table->dropColumn('foreign_user_id');
        });
    }
}
