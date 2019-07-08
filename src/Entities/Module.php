<?php namespace WebReinvent\VaahCms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ZanySoft\Zip\Zip;

class Module extends Model {

    use SoftDeletes;
    //-------------------------------------------------
    protected $table = 'vh_modules';
    //-------------------------------------------------
    protected $dates = [
        'update_checked_at',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
        'title',
        'name',
        'slug',
        'github_url',
        'excerpt',
        'description',
        'author_name',
        'author_website',
        'version',
        'version_number',
        'db_table_prefix',
        'is_active',
        'is_sample_data_available',
        'is_update_available',
        'update_checked_at',
    ];

    //-------------------------------------------------
    public function setSlugAttribute( $value ) {
        $this->attributes['slug'] = str_slug( $value );
    }
    //-------------------------------------------------
    public function scopeActive( $query ) {
        return $query->where( 'is_active', 1 );
    }

    //-------------------------------------------------
    public function scopeInactive( $query ) {
        return $query->whereNull( 'is_active');
    }

    //-------------------------------------------------
    public function scopeUpdateAvailable( $query ) {
        return $query->where( 'is_update_available', 1 );
    }
    //-------------------------------------------------
    public function scopeSlug( $query, $slug ) {
        return $query->where( 'slug', $slug );
    }
    //-------------------------------------------------


    //-------------------------------------------------
    public function scopeCreatedBetween( $query, $from, $to ) {
        return $query->whereBetween( 'created_at', array( $from, $to ) );
    }

    //-------------------------------------------------
    public function scopeUpdatedBetween( $query, $from, $to ) {
        return $query->whereBetween( 'updated_at', array( $from, $to ) );
    }

    //-------------------------------------------------
    public function scopeDeletedBetween( $query, $from, $to ) {
        return $query->whereBetween( 'deleted_at', array( $from, $to ) );
    }
    //-------------------------------------------------
    public function settings()
    {
        return $this->morphMany('WebReinvent\VaahCms\Entities\Setting', 'settingable');
    }
    //-------------------------------------------------
    public function migrations()
    {
        return $this->morphMany('WebReinvent\VaahCms\Entities\Migration', 'migrationable');
    }
    //-------------------------------------------------
    public static function syncModule($module_path)
    {

        $settings = vh_get_module_settings_from_path($module_path);


        if(is_null($settings) || !is_array($settings) || count($settings) < 1)
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Fatal with '.$module_path.'\settings.json';
            return $response;
        }

        $rules = array(
            'name' => 'required',
            'title' => 'required',
            'slug' => 'required',
            'thumbnail' => 'required',
            'excerpt' => 'required',
            'github_url' => 'required',
            'author_name' => 'required',
            'author_website' => 'required',
            'version' => 'required',
        );

        $validator = \Validator::make( $settings, $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }


        $settings['version_number'] =  str_replace('v','',$settings['version']);
        $settings['version_number'] =  str_replace('.','',$settings['version_number']);

        $module = Module::firstOrCreate(['slug' => $settings['slug']]);
        $module->fill($settings);
        $module->save();

        $removeKeys = [
            'name',
            'title',
            'description',
            'slug',
            'thumbnail',
            'excerpt',
            'github_url',
            'author_name',
            'author_website',
            'is_sample_data_available',
            'version',
        ];


        $other_settings = array_diff_key($settings, array_flip($removeKeys));

        foreach ($other_settings as $key => $setting_input)
        {

            $setting_data = [];

            $setting_data['key'] = $key;

            if(is_array($setting_input) || is_object($setting_input))
            {
                $setting_data['type'] = 'json';
                $setting_data['value'] = json_encode($setting_input);

            } else
            {
                $setting_data['value'] = $setting_input;
            }

            $setting = new Setting($setting_data);

            $module->settings()->save($setting);

        }


        $module = Module::where('slug', $module->slug)->with(['settings'])->first();

        return $module;


    }
    //-------------------------------------------------
    public static function syncAllModules()
    {
        $list = vh_get_all_modules_paths();
        if(count($list) < 1)
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'No module installed/downloaded';
            return $response;
        }

        foreach($list as $module_path)
        {
            Module::syncModule($module_path);

        }

    }
    //-------------------------------------------------
    public static function getInstalledModules()
    {
        $list = Model::all();
        return $list;
    }
    //-------------------------------------------------
    public static function validateDependencies($dependencies)
    {

        $response['status'] = 'success';


        foreach ($dependencies as $key => $dependency_list)
        {


            switch($key){

                case 'modules':

                    if(is_array($dependency_list))
                    {
                        foreach ($dependency_list as $dependency_slug)
                        {
                            $module = Module::slug($dependency_slug)->first();

                            if(!$module)
                            {
                                $response['status'] = 'failed';
                                $response['errors'][] = "Please install and activate '".$dependency_slug."'.";
                            }

                            if($module && $module->is_active != 1)
                            {
                                $response['status'] = 'failed';
                                $response['errors'][] = $dependency_slug.' module is not active';
                            }
                        }

                    }

                    break;
                //------------------------
                case 'theme':

                    break;
                //------------------------
                //------------------------
                //------------------------
                //------------------------
            }



        }

        return $response;
    }
    //-------------------------------------------------
    public static function activate($slug)
    {
        $module = Module::slug($slug)->first();

        $path = "./vaahcms/Modules/".$module->name."/Database/migrations/";
        $path_des = "./database/migrations";

        //\copy($path, $path_des);

        \File::copyDirectory($path, $path_des);

        //run migration
        $command = 'migrate';
        \Artisan::call($command);
        Migration::syncModuleMigrations($module->id);

        $command = 'db:seed';
        $params = [
            '--class' => "VaahCms\Modules\\{$module->name}\\Database\Seeds\DatabaseTableSeeder"
        ];

        \Artisan::call($command, $params);

        $module->is_active = 1;
        $module->save();

    }
    //-------------------------------------------------
    public static function download($slug)
    {

        $api = config('vaahcms.api_route')."/module/by/slug/".$slug;

        $api_response = @file_get_contents($api);
        $api_response = json_decode($api_response);

        if($api_response->status != 'success')
        {
            return $api_response;
        }

        //check if module is already installed
        $module_path = base_path()."/vaahcms/Modules/".$api_response->data->name;
        if(is_dir($module_path))
        {
            $response['status'] = 'success';
            $response['messages'][] = $api_response->data->name." module already exist.";
            return $response;
        }

        $parsed = parse_url($api_response->data->github_url);


        $uri_parts = explode('/', $parsed['path']);
        $folder_name = end($uri_parts);
        $folder_name = $folder_name."-master";


        $filename = $api_response->data->name.'.zip';
        $folder_path = base_path()."/vaahcms/Modules/";
        $path = $folder_path.$filename;

        copy($api_response->data->github_url.'/archive/master.zip', $path);

        try{
            Zip::check($path);
            $zip = Zip::open($path);
            $zip->extract(base_path().'/vaahcms/Modules/');
            $zip->close();

            rename($folder_path."".$folder_name, $folder_path.$api_response->data->name);

            vh_delete_folder($path);

            $response['status'] = 'success';
            $response['messages'][] = 'installed';
            return $response;

        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
            return $response;
        }

    }
    //-------------------------------------------------
    public static function importSampleData($slug)
    {
        $module = Module::slug($slug)->first();

        $command = 'db:seed';
        $params = [
            '--class' => "VaahCms\Modules\\{$module->name}\\Database\Seeds\SampleDataTableSeeder"
        ];

        \Artisan::call($command, $params);
    }
    //-------------------------------------------------

    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------

}
