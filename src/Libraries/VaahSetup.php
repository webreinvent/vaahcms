<?php
namespace WebReinvent\VaahCms\Libraries;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use WebReinvent\VaahCms\Entities\User;
use WebReinvent\VaahCms\Notifications\TestSmtp;

use Dotenv\Dotenv;

class VaahSetup{

    //----------------------------------------------------------
    /*
     * $list_type will accept: key_value | list
     */
    public static function generateEnvFile($request, $list_type='key_value', $env_file_name=null)
    {

        try{

            if($list_type=='key_value')
            {
                $html = view('vaahcms::templates.env')
                    ->with('data', (object)$request->all())
                    ->render();
            }

            if($list_type=='list')
            {
                $html = view('vaahcms::templates.env_v2')
                    ->with('data', (object)$request->all())
                    ->render();
            }

            $html = html_entity_decode($html);

            if($request->has('app_env'))
            {
                $file_name = '.env.'.$request->app_env;
            } else if($env_file_name)
            {
                $file_name = $env_file_name;
            } else
            {
                $file_name = self::getActiveEnvFileName();
            }

            VaahFile::createFile(base_path('/'), $file_name, $html);

            $response['status'] = 'success';
            $response['data'] = [];
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
                        "thumbnail"=> "https://placehold.jp/300x160.png",
                        "excerpt"=> "CMS is a framework for creating, managing, and deploying customized content types and fields.",
                        "author_name"=> "WebReinvent",
                        "author_website"=> "https://placehold.jp/300x160.png",
                        "version"=> "v0.0.1",
                        "is_sample_data_available"=> true,
                        "import_sample_data"=> false,

                    ],
                    [
                        "name"=> "BtFourPointFour",
                        "slug"=> "BtFourPointFour",
                        "type"=> "theme",
                        "source"=> "vaahcms",
                        "download_link"=> "",
                        "title"=> "Bootstrap 4.4 Theme",
                        "thumbnail"=> "https://placehold.jp/300x160.png",
                        "excerpt"=> "Bootstrap 4.3 Theme for VaahCMS",
                        "github_url"=> "https://placehold.jp/300x160.png",
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

                if($file == '.env.example')
                {
                    continue;
                }

                if($file == '.env')
                {
                    if(File::exists(base_path($file)))
                    {
                        $env_params = vh_env_file_to_array(base_path($file));
                        $data['environments']['default']['env_file'] = $file;
                        $data['environments']['default']['app_url'] = $env_params['APP_URL'];
                    }
                } else{
                    if (strpos($file, '.env') !== false) {
                        if(File::exists(base_path($file)))
                        {
                            $env_params = vh_env_file_to_array(base_path($file));

                            $env = trim($env_params['APP_ENV']);
                            $env_url = trim($env_params['APP_URL']);

                            $data['environments'][$env]['env_file'] = trim($file);
                            $data['environments'][$env]['app_url'] = $env_url;
                        }
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
    public static function isDBConnected()
    {
        try {
            \DB::connection()->getPdo();
            return true;
        } catch (\Exception $e) {
            return false;
        }

    }
    //----------------------------------------------------------
    public static function isDBMigrated()
    {
        try {
            $exist = \Schema::hasTable('vh_users');
            return $exist;
        } catch (\Exception $e) {
            return false;
        }
    }
    //----------------------------------------------------------
    public static function isInstalled()
    {

        $data['stage'] = "";

        if(static::isDBConnected())
        {
            $data['stage'] = 'database';
        }

        if(static::isDBMigrated())
        {
            $data['stage'] = 'migrated';
        }

        if(static::isAdminCreated())
        {
            $data['stage'] = 'installed';
        }

        if($data['stage'] == 'installed')
        {
            return true;
        }

        return false;

    }
    //----------------------------------------------------------
    public static function isAdminCreated()
    {
        $db_connected = static::isDBConnected();
        $db_migrated = static::isDBMigrated();

        if(!$db_connected || !$db_migrated)
        {
            return false;
        }

        $count = User::countAdministrators();

        if($count > 0)
        {
            return true;
        }


    }
    //----------------------------------------------------------
    public static function getActiveEnvFileName()
    {
        $vaahcms_file = base_path('/vaahcms.json');
        $env_file_name = '.env';

        if(file_exists($vaahcms_file))
        {

            $host = null;
            $actual_url = null;

            if(isset($_SERVER) && isset($_SERVER['HTTP_HOST']))
            {
                $actual_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            }


            if($actual_url)
            {
                $vaahcms = file_get_contents(base_path('/vaahcms.json'));
                $vaahcms = json_decode($vaahcms, true);

                if(isset($vaahcms['environments']) && is_array($vaahcms['environments'])
                    && count($vaahcms['environments'])>0
                )
                {
                    foreach ($vaahcms['environments'] as $environment)
                    {
                        $environment_url = explode( '://', $environment['app_url']);
                        if (strpos($actual_url, $environment_url[1]) !== false){
                            $env_file_name = $environment['env_file'];
                        }

                    }

                    if(!file_exists(base_path($env_file_name)))
                    {
                        $env_file_name = '.env';
                    }

                }
            }



        }

        return $env_file_name;

    }
    //----------------------------------------------------------
    /*
     * $list_type will accept: key_value | list
     */
    public static function getEnvFileVariables($env_file=null, $list_type='key_value', $key_lower=false)
    {
        if(!$env_file)
        {
            $env_file = self::getActiveEnvFileName();
        }

        $env_file_path = base_path($env_file);

        $string      = file_get_contents($env_file_path);
        $string      = preg_split('/\n+/', $string);
        $returnArray = array();

        foreach ($string as $one) {
            if (preg_match('/^(#\s)/', $one) === 1 || preg_match('/^([\\n\\r]+)/', $one)) {
                continue;
            }
            $entry                  = explode("=", $one, 2);
            $returnArray[$entry[0]] = isset($entry[1]) ? $entry[1] : null;
        }

        $list = array_filter(
            $returnArray,
            function ($key) {
                return !empty($key);
            },
            ARRAY_FILTER_USE_KEY
        );

        $result = [];
        $i = 0;
        foreach ($list as $key => $value)
        {
            if($key_lower)
            {
                $key = strtolower($key);
            }

            if($list_type == 'key_value')
            {
                $result[$key] = $value;
            }

            if($list_type == 'list')
            {
                $result[$i]['key'] = $key;
                $result[$i]['value'] = $value;
            }

            $i++;
        }

        return $result;

    }
    //----------------------------------------------------------
    public static function publishConfig($namespace=null)
    {
        if(!$namespace)
        {
            $namespace = 'WebReinvent\VaahCms\Database\Seeders\VaahCmsTableSeeder';

        }

        $command = 'vendor:publish';

        $params = [];
        $params['--tag'] = 'config';
        $params['--force'] = true;
        if($namespace)
        {
            $params['--class'] = $namespace;
        }

        \Artisan::call($command, $params);

    }
    //----------------------------------------------------------
    public static function publishAssets($namespace=null)
    {
        if(!$namespace)
        {
            $namespace = 'WebReinvent\VaahCms\Database\Seeders\VaahCmsTableSeeder';

        }

        $command = 'vendor:publish';

        $params = [];
        $params['--tag'] = 'assets';
        $params['--force'] = true;
        if($namespace)
        {
            $params['--class'] = $namespace;
        }

        \Artisan::call($command, $params);

    }
    //----------------------------------------------------------
    //----------------------------------------------------------

}
