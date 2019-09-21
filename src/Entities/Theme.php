<?php namespace WebReinvent\VaahCms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use ZanySoft\Zip\Zip;

class Theme extends Model {

    use SoftDeletes;
    //-------------------------------------------------
    protected $table = 'vh_themes';
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
        'thumbnail',
        'github_url',
        'excerpt',
        'description',
        'author_name',
        'author_website',
        'version',
        'version_number',
        'is_active',
        'is_sample_data_available',
        'is_update_available',
        'update_checked_at',
    ];

    //-------------------------------------------------
    public function setSlugAttribute( $value ) {
        $this->attributes['slug'] = Str::slug( $value );
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
    public function migrations()
    {
        return $this->morphMany('WebReinvent\VaahCms\Entities\Migration', 'migrationable');
    }
    //-------------------------------------------------
    public function settings()
    {
        return $this->morphMany('WebReinvent\VaahCms\Entities\Setting', 'settingable');
    }
    //-------------------------------------------------
    public function formGroups()
    {
        return $this->morphMany('WebReinvent\VaahCms\Entities\Migration', 'groupable');
    }
    //-------------------------------------------------
    public function themeTemplates()
    {
        return $this->hasMany('WebReinvent\VaahCms\Entities\ThemeTemplate',
            'vh_theme_id', 'id');
    }
    //-------------------------------------------------
    public function pageTemplates()
    {
        return $this->hasMany('WebReinvent\VaahCms\Entities\ThemeTemplate',
            'vh_theme_id', 'id')
            ->where('type', 'page');
    }

    //-------------------------------------------------
    public function defaultPageTemplate()
    {
        return $this->hasOne('WebReinvent\VaahCms\Entities\ThemeTemplate',
            'vh_theme_id', 'id')
            ->where('type', 'page')
            ->where('slug', 'default');
    }
    //-------------------------------------------------
    public static function syncTheme($path)
    {

        $settings = vh_get_theme_settings_from_path($path);


        if(is_null($settings) || !is_array($settings) || count($settings) < 1)
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Fatal with '.$path.'\settings.json';
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

        $theme = Theme::firstOrCreate(['slug' => $settings['slug']]);
        $theme->fill($settings);
        $theme->save();

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

            $theme->settings()->save($setting);
        }

        $theme = Theme::where('slug', $theme->slug)->with(['settings'])->first();

        return $theme;

    }
    //-------------------------------------------------
    public static function syncAll()
    {
        $list = vh_get_all_themes_paths();

        if(count($list) < 1)
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'No theme installed/downloaded';
            return $response;
        }

        foreach($list as $path)
        {
            Theme::syncTheme($path);
        }

        return true;
    }
    //-------------------------------------------------
    public static function getInstalledThemes()
    {
        $list = Theme::all();
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
    public static function download($slug)
    {

        $api = config('vaahcms.api_route')."/theme/by/slug/".$slug;

        $api_response = @file_get_contents($api);

        if(!isset($api_response) || empty($api_response))
        {
            $response['status'] = 'failed';
            $response['data']['url'] = $api;
            $response['errors'][] = 'API Response Error.';
            return $response;
        }

        $api_response = json_decode($api_response);

        if(!isset($api_response) || !isset($api_response->status) || $api_response->status != 'success')
        {
            $response['status'] = 'failed';
            $response['data']['url'] = $api;
            $response['data']['data'] = $api_response;
            $response['errors'][] = 'API Response Error.';
            return $response;

        }


        if($api_response->status != 'success')
        {
            return $api_response;
        }

        //check if module is already installed
        $theme_path = config('vaahcms.themes_path')."/".$api_response->data->name;
        if(is_dir($theme_path))
        {
            $response['status'] = 'success';
            $response['messages'][] = $api_response->data->name." theme already exist.";
            return $response;
        }

        $parsed = parse_url($api_response->data->github_url);


        $uri_parts = explode('/', $parsed['path']);
        $folder_name = end($uri_parts);
        $folder_name = $folder_name."-master";


        $filename = $api_response->data->name.'.zip';
        $folder_path = config('vaahcms.themes_path')."/";
        $path = $folder_path.$filename;

        copy($api_response->data->github_url.'/archive/master.zip', $path);

        try{
            Zip::check($path);
            $zip = Zip::open($path);
            $zip->extract(config('vaahcms.themes_path'));
            $zip->close();

            rename($folder_path.$folder_name, $folder_path.$api_response->data->name);

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
    public static function activate($slug)
    {
        $theme = Theme::slug($slug)->first();

        $path = "/".config('vaahcms.root_folder')."/".$theme->name."/Database/Migrations/";

        Migration::runMigrations($path);

        Migration::syncThemeMigrations($theme->id);

        $seeds_namespace = config('vaahcms.root_folder')."\Themes\\{$theme->name}\\Database\Seeds\DatabaseTableSeeder";

        Migration::runSeeds($seeds_namespace);

        $theme->is_active = 1;
        $theme->save();

    }
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
    public static function importSampleData($slug)
    {
        $item = Theme::slug($slug)->first();

        $command = 'db:seed';
        $params = [
            '--class' => config('vaahcms.root_folder')."\Themes\\{$item->name}\\Database\Seeds\SampleDataTableSeeder"
        ];

        \Artisan::call($command, $params);


    }
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------

}
