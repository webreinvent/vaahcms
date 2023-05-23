<?php
namespace WebReinvent\VaahCms\Libraries;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use WebReinvent\VaahCms\Models\User;
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

            if($env_file_name)
            {
                $file_name = $env_file_name;
            }else if($request->has('app_env_custom') && $request->app_env_custom)
            {
                $file_name = '.env.'.$request->app_env_custom;
            }else if($request->has('app_env') && $request->app_env)
            {
                $file_name = '.env.'.$request->app_env;
            }else
            {
                $file_name = self::getActiveEnvFileName();
            }

            VaahFile::createFile(base_path('/'), $file_name, $html);

            $response['success'] = true;
            $response['data'] = [];
            return $response;

        }catch(\Exception $e)
        {
            $response['success'] = false;
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
                        "thumbnail"=> "https://img.site/p/300/160",
                        "excerpt"=> "CMS is a framework for creating, managing, and deploying customized content types and fields.",
                        "author_name"=> "Vaah",
                        "author_website"=> "https://vaah.dev",
                        "version"=> "v0.1.6",
                        "is_sample_data_available"=> true,
                        "import_sample_data"=> false,
                    ],
                    [
                        "name"=> "BulmaBlogTheme",
                        "slug"=> "bulmablogtheme",
                        "type"=> "theme",
                        "source"=> "vaahcms",
                        "download_link"=> "",
                        "title"=> "Bulma 0.9.2 Blog",
                        "thumbnail"=> "https://img.site/p/300/160",
                        "excerpt"=> "Bulma 0.9.2 Blog Theme for VaahCMS",
                        "github_url"=> "https://github.com/webreinvent/vaahcms-theme-bulma",
                        "author_name"=> "WebReinvent",
                        "author_website"=> "https://webreinvent.com",
                        "version"=> "v0.0.2",
                        "is_sample_data_available"=> true,
                        "import_sample_data"=> true,
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

                $env_params = [];

                if($file == '.env.example' || $file == '.env.example.default')
                {
                    continue;
                }

                if($file == '.env')
                {
                    if(File::exists(base_path($file)))
                    {
                        $env_params = vh_env_file_to_array(base_path($file));
                        $data['environments']['default']['env_file'] = $file;
                        $data['environments']['default']['app_url'] = 'http://localhost';
                    }

                } else{
                    if (strpos($file, '.env.') !== false) {
                        if(File::exists(base_path($file)))
                        {
                            $env_params = vh_env_file_to_array(base_path($file));

                            if(isset($env_params['APP_ENV']) && isset($env_params['APP_URL']))
                            {
                                $env = trim($env_params['APP_ENV']);
                                $env_url = trim($env_params['APP_URL']);

                                $data['environments'][$env]['env_file'] = trim($file);
                                $data['environments'][$env]['app_url'] = $env_url;
                            }

                        }
                    }
                }



            }


            VaahFile::createJsonFileFromArray($data, 'vaahcms.json');

            $response['success'] = true;
            $response['data'] = [];

        }catch(\Exception $e)
        {
            $response['success'] = false;
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

        if(static::isSuperAdminCreated())
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
    public static function isSuperAdminCreated()
    {
        $db_connected = static::isDBConnected();
        $db_migrated = static::isDBMigrated();

        if(!$db_connected || !$db_migrated)
        {
            return false;
        }

        $count = User::countSuperAdministrators();

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
                $result[$key] = trim($value);
            }

            if($list_type == 'list')
            {
                $result[$i]['key'] = $key;
                $result[$i]['value'] = trim($value);
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
            $namespace = 'WebReinvent\VaahCms\VaahCmsServiceProvider';

        }

        $command = 'vendor:publish';

        $params = [];
        $params['--tag'] = 'config';
        $params['--force'] = true;
        if($namespace)
        {
            $params['--provider'] = $namespace;
        }

        \Artisan::call($command, $params);

    }
    //----------------------------------------------------------
    public static function publishAssets($namespace=null)
    {
        if(!$namespace)
        {
            $namespace = 'WebReinvent\VaahCms\VaahCmsServiceProvider';

        }

        $command = 'vendor:publish';

        $params = [];
        $params['--tag'] = 'assets';
        $params['--force'] = true;
        if($namespace)
        {
            $params['--provider'] = $namespace;
        }

        \Artisan::call($command, $params);

    }
    //----------------------------------------------------------
    public static function publishDotEnv($namespace=null)
    {
        try{
            \File::copy(base_path('.env.example'),base_path('.env'));

            $response['success'] = true;
            $response['data'][] = '';


        }catch(\Exception $e)
        {
            $response['success'] = false;
            $response['errors'][] = $e->getMessage();
        }


        return $response;


    }
    //----------------------------------------------------------
    public static function generateAppKey($env_suffix=null)
    {

        $command = 'key:generate';

        $params = [];

        if($env_suffix)
        {
            $params['--env'] = $env_suffix;
        }

        $params['--force'] = true;

        \Artisan::call($command, $params);

    }
    //----------------------------------------------------------
    public static function verifyAppUrl($request)
    {

        $path = base_path('/vaahcms.json');

        if (!File::exists($path)) {
            $response['success'] = true;
            $response['data'][] = '';
            if(env('APP_DEBUG'))
            {
                $response['hint'][] = 'vaahcms.json file does not exist';
            }
            return $response;
        }

        $config = [];
        $file = File::get($path);
        $plugin_config = json_decode($file);
        $config = (array)$plugin_config;

        if(!isset($config['environments']))
        {
            $response['success'] = true;
            $response['data'][] = '';
            if(env('APP_DEBUG'))
            {
                $response['hint'][] = 'environments are not defined yet in vaahcms.json';
            }
            return $response;
        }


        if($config['environments'])
        {

            $list = collect($config['environments'])->pluck('app_url')->toArray();

            $duplicates = array();
            foreach(array_count_values($list) as $val => $c)
            {
                if($c > 1) $duplicates[] = $val;
            }

            if(!empty($duplicates) && count($duplicates) > 0)
            {
                $duplicate_urls = implode( ', ', $duplicates);

                $response['success'] = false;
                $response['messages'][] = 'Duplicate entries for app_url(s) '.$duplicate_urls.' is/are found in vaahcms.json file.';
                if(env('APP_DEBUG'))
                {
                    $response['hint'][] = 'APP URL already exist in vaahcms.json';
                }

                return $response;
            }

            /*foreach($config['environments'] as $key => $environment)
            {
                if( $environment->app_url === url("/") && $environment->env_file != '.env.'.$request->app_env)
                {
                    $response['success'] = false;
                    $response['errors'][] = 'APP_URL ('.$environment->app_url.') already exist in vaahcms.json for '.$environment->env_file.' file.';
                    if(env('APP_DEBUG'))
                    {
                        $response['hint'][] = 'APP URL already exist in vaahcms.json';
                    }
                    return $response;
                }
            }*/
        }

        $response['success'] = true;
        $response['data'][] = '';

        return $response;

    }
    //----------------------------------------------------------
    public static function isAppUrlExistInVaahCmsJson($request)
    {
        $path = base_path('/vaahcms.json');

        if(!File::exists($path)){
            return false;
        }

        $file = File::get($path);
        $plugin_config = json_decode($file);
        $vaahcms_json = (array)$plugin_config;

        foreach($vaahcms_json['environments'] as $key => $vaahcms_json_environment)
        {
            if( $vaahcms_json_environment->app_url === url("/") && $vaahcms_json_environment->env_file != '.env.'.$request->app_env)
            {
                return true;
            }
        }

        return false;
    }
    //----------------------------------------------------------

}
