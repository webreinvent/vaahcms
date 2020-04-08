<?php
namespace WebReinvent\VaahCms\Libraries;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use WebReinvent\VaahCms\Notifications\TestSmtp;

use Dotenv\Dotenv;

class VaahSetup{

    //----------------------------------------------------------
    public static function generateEnvFile($request)
    {

        try{

            $html = view('vaahcms::templates.env')
                ->with('data', (object)$request->all())
                ->render();

            $html = html_entity_decode($html);

            $file_name = '.env.'.$request->app_env;

            VaahFile::createFile(base_path('/'), $file_name, $html);

            $response['status'] = 'success';
            return $response;

        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
            return $response;
        }


    }
    //----------------------------------------------------------
    public static function createVaahCmsJsonFile($request)
    {

        try{

            $files = vh_get_all_files(base_path('/'));

            $data['environments'] = [];

            foreach ($files as $file)
            {
                if (strpos($file, '.env') !== false) {

                    if(File::exists(base_path($file)))
                    {
                        $env_params = vh_env_file_to_array(base_path($file));
                        $data['environments'][$env_params['APP_ENV']]['env_file'] = $file;
                        $data['environments'][$env_params['APP_ENV']]['app_url'] = $env_params['APP_URL'];
                    }

                }
            }

            VaahFile::createJsonFileFromArray($data, 'vaahcms.json');

            $response['status'] = 'success';
            $response['data'] = [];

        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();

        }

        return $response;
    }
    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------

}
