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

            $vaahcms_params = [];
            $data = [
                "dependencies" => [
                    [
                        "name"=> "Cms",
                        "slug"=> "cms",
                        "type"=> "module",
                        "source"=> "vaahcms",
                        "download_link"=> "",
                        "title"=> "CMS module to manage your content",
                        "thumbnail"=> "http=>//themepixels.me/dashforge/assets/img/placehold.jpg",
                        "excerpt"=> "CMS is a framework for creating, managing, and deploying customized content types and fields.",
                        "author_name"=> "WebReinvent",
                        "author_website"=> "https=>//www.webreinvent.com",
                        "version"=> "v0.0.1",
                        "is_sample_data_available"=> true,
                        "import_sample_data"=> false,

                    ],
                    [
                        "name"=> "BtFourPointThree",
                        "slug"=> "btfourpointthree",
                        "type"=> "theme",
                        "source"=> "vaahcms",
                        "download_link"=> "",
                        "title"=> "Bootstrap 4.3 Theme",
                        "thumbnail"=> "http=>//themepixels.me/dashforge/assets/img/placehold.jpg",
                        "excerpt"=> "Bootstrap 4.3 Theme for VaahCMS",
                        "github_url"=> "https=>//github.com/webreinvent/vaahcms-theme-btfourpointthree",
                        "author_name"=> "WebReinvent",
                        "author_website"=> "https=>//www.webreinvent.com",
                        "version"=> "v0.0.1",
                        "is_sample_data_available"=> true,
                        "import_sample_data"=> false,

                    ]
                ],
                "environments"=>[]
            ];

            if(File::exists(base_path('vaahcms.json'))){
                $vaahcms_params = file_get_contents(base_path('/vaahcms.json'));
                $vaahcms_params = json_decode($vaahcms_params, true);

                if(is_array($vaahcms_params) && !empty($vaahcms_params))
                {
                    foreach ($vaahcms_params as $key => $param)
                    {
                        $data[$key] = $param;
                    }
                }

                File::delete(base_path('vaahcms.json'));
            }



            $files = vh_get_all_files(base_path('/'));

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

    public static function getDependencies()
    {
        $list = VaahHelper::getVaahCMSJsonFileParam('dependencies');
        return $list;
    }

    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------

}
