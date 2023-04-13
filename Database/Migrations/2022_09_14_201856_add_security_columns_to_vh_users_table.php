<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSecurityColumnsToVhUsersTable extends Migration
{
    public function table()
    {
        return 'vh_users';
    }

    public function columns()
    {
        return [
            [
                "type"=>"text",
                "column"=>"mfa_methods",
                "after"=>"country_code",
            ],
            [
                "type"=>"string",
                "column"=>"security_code",
                "length"=>50,
                "after"=>"status",
            ],
            [
                "type"=>"dateTime",
                "column"=>"security_code_expired_at",
                "after"=>"security_code",
            ]
        ];
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $table = $this->table();
        $list = $this->columns();

        foreach ($list as $item)
        {
            if(!Schema::hasColumn($table, $item['column'])){
                Schema::table($table, function (Blueprint $table) use ($item)
                {
                    $type = $item['type'];
                    $column = $item['column'];
                    if(isset($item['after']))
                    {
                        $table->$type($column,isset($item['length']) ? $item['length'] : null)
                            ->nullable()->after($item['after']);
                    }  else
                    {
                        $table->$type($column,isset($item['length']) ? $item['length'] : null)
                            ->nullable();
                    }
                });
            }
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = $this->table();
        $list = $this->columns();
        foreach ($list as $item)
        {
            if(Schema::hasColumn($table, $item['column'])){
                Schema::table($table, function (Blueprint $table) use ($item)
                {
                    $column = $item['column'];
                    $table->dropColumn($column);
                });
            }
        }
    }
}
