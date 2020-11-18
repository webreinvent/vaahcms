<?php
namespace WebReinvent\VaahCms\Libraries;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class VaahDB{

    //----------------------------------------------------------

    public static function import($sql_file_path)
    {

        DB::unprepared($sql_file_path);

    }

    //----------------------------------------------------------
    public static function export($output_folder='backups')
    {



    }
    //----------------------------------------------------------
    //----------------------------------------------------------

    //----------------------------------------------------------

}
