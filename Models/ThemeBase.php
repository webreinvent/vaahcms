<?php namespace WebReinvent\VaahCms\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use ZanySoft\Zip\Zip;


class ThemeBase extends Model {

    use SoftDeletes;
    //-------------------------------------------------
    protected $connection= 'mysql';
    //-------------------------------------------------
    protected $table = 'vh_themes';

    //-------------------------------------------------
    protected $casts = [
        'update_checked_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
        'title',
        'name',
        'slug',
        'download_link',
        'excerpt',
        'description',
        'author_name',
        'author_website',
        'vaah_url',
        'version',
        'version_number',
        'db_table_prefix',
        'is_active',
        'is_default',
        'is_migratable',
        'is_assets_published',
        'is_sample_data_available',
        'is_update_available',
        'update_checked_at',
    ];

    //-------------------------------------------------

    protected function serializeDate(DateTimeInterface $date)
    {
        $date_time_format = config('settings.global.datetime_format');

        return $date->format($date_time_format);

    }

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
        return $this->morphMany('WebReinvent\VaahCms\Models\Migration', 'migrationable');
    }
    //-------------------------------------------------
    public function settings()
    {
        return $this->morphMany('WebReinvent\VaahCms\Models\Setting', 'settingable');
    }
    //-------------------------------------------------
    public function templates()
    {
        return $this->hasMany(ThemeTemplate::class,
            'vh_theme_id', 'id');
    }
    //-------------------------------------------------
    public function locations()
    {
        return $this->hasMany(ThemeLocation::class,
            'vh_theme_id', 'id');
    }
    //-------------------------------------------------
    public static function getItem($id)
    {

        $item = static::where('id', $id)
            ->withTrashed()
            ->first();

        $response['success'] = true;
        $response['data'] = $item;

        return $response;

    }
    //-------------------------------------------------
    public static function syncTheme($path)
    {

        $settings = vh_get_theme_settings_from_path($path);


        if(is_null($settings) || !is_array($settings) || count($settings) < 1)
        {
            $response['success'] = false;
            $response['errors'][] = 'Fatal with '.$path.'\Config\config.php';
            return $response;
        }

        $rules = array(
            'name' => 'required',
            'title' => 'required',
            'slug' => 'required',
            'thumbnail' => 'required',
            'excerpt' => 'required',
            'author_name' => 'required',
            'author_website' => 'required',
            'version' => 'required',
        );

        $validator = \Validator::make( $settings, $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
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
            'download_link',
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

        $installed = static::orderBy('name', 'asc')->get()
            ->pluck('name')->toArray();

        if($installed && count($list) < 1)
        {
            foreach ($installed as $item)
            {
                $installed_theme = static::where('name', $item)->first();
                $installed_theme->forceDelete();
            }
        }

        if(count($list) < 1)
        {
            $response['success'] = false;
            $response['errors'][] = 'No theme installed/downloaded';
            return $response;
        }

        $installed_names = [];

        if(count($list) > 0)
        {
            foreach ($list as $module_path)
            {
                $installed_names[] = basename($module_path);
            }
        }

        //remove database records if module folder does not exist
        if(count($installed_names) > 0)
        {
            foreach ($installed as $item)
            {
                if(!in_array($item, $installed_names))
                {
                    $installed_theme = static::where('name', $item)->first();
                    $installed_theme->forceDelete();
                }
            }
        }

        foreach($list as $module_path)
        {
            $res = Theme::syncTheme($module_path);
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
    public static function getActiveThemes()
    {
        return static::where('is_active', 1)
            ->orderBy('is_default', 'desc')
            ->get();
    }
    //-------------------------------------------------
    public static function getActiveThemesWithMenuLocations()
    {
        $type = 'menu';

        return static::where('is_active', 1)
            ->with('locations', function ($q) use ($type){
                $q->where('type', $type);
                $q->with('menus.items.content');
            })
            ->whereHas('locations', function ($q) use ($type){
                $q->where('type', $type);
            })
            ->orderBy('is_default', 'desc')
            ->get();
    }
    //-------------------------------------------------
    public static function getActiveThemesWithBlockLocations()
    {
        $type = 'block';

        return static::where('is_active', 1)
            ->with('locations', function ($q) use ($type){
                $q->where('type', $type);
            })
            ->whereHas('locations', function ($q) use ($type){
                $q->where('type', $type);
            })
            ->orderBy('is_default', 'desc')
            ->get();
    }
    //-------------------------------------------------
    public static function getActiveThemesWithRelations()
    {
        return static::where('is_active', 1)
            ->with(['templates.fields'])
            ->orderBy('is_default', 'desc')
            ->get();
    }
    //-------------------------------------------------
    public static function getDefaultThemesAndTemplateWithRelations($content_slug)
    {

        $result['theme'] = static::whereNotNull('is_active')
            ->with(['templates.groups.fields.type'])
            ->whereNotNull('is_default')
            ->first();

        $theme = static::whereNotNull('is_active')
            ->whereNotNull('is_default')
            ->with(['templates' => function($t) use ($content_slug){
                $t->where('slug', $content_slug)->with(['groups.fields.type']);
            }])
            ->first();

        if($theme && isset($theme->templates[0]))
        {
            $result['template'] = $theme->templates[0];
        } else {
            $theme = static::whereNotNull('is_active')
                ->whereNotNull('is_default')
                ->with(['templates' => function($t) {
                    $t->where('slug', 'default')->with(['groups.fields.type']);
                }])
                ->first();

            if($theme && isset($theme->templates[0]))
            {
                $result['template'] = $theme->templates[0];
            }

            $result['template'] = [];

        }

        return $result;
    }
    //-------------------------------------------------
    public static function validateDependencies($dependencies)
    {

        $response['success'] = true;


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
                                $response['success'] = false;
                                $response['errors'][] = "Please install and activate '".$dependency_slug."' module.";
                            }

                            if($module && $module->is_active != 1)
                            {
                                $response['success'] = false;
                                $response['errors'][] = $dependency_slug.' module is not active';
                            }
                        }

                    }

                    break;
                //------------------------
                case 'themes':

                    if(is_array($dependency_list))
                    {
                        foreach ($dependency_list as $dependency_slug)
                        {
                            $theme = Theme::slug($dependency_slug)->first();

                            if(!$theme)
                            {
                                $response['success'] = false;
                                $response['errors'][] = "Please install and activate '".$dependency_slug."' theme.";
                            }

                            if($theme && $theme->is_active != 1)
                            {
                                $response['success'] = false;
                                $response['errors'][] = $dependency_slug.' theme is not active';
                            }
                        }

                    }

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
    public static function activateItem($slug, $is_default=false)
    {

        $item = static::slug($slug)->first();

        /*
         * get theme dependencies
         */
        $response = vh_theme_action($item->name, 'SetupController@dependencies');

        if(isset($response['success']) && !$response['success'])
        {
            return $response;
        }

        /*
         * check theme dependencies are installed
         */
        $response = static::validateDependencies($response['data']);


        if(isset($response['success']) && !$response['success'])
        {
            return $response;
        }


        if(!isset($item->is_migratable) || (isset($item->is_migratable) && $item->is_migratable == true))
        {

            $path = vh_theme_migrations_path($item->name);

            $max_batch = \DB::table('migrations')
                ->max('batch');

            Migration::runMigrations($path);

            $current_max_batch = \DB::table('migrations')
                ->max('batch');

            if($current_max_batch > $max_batch){
                Migration::syncThemeMigrations($item->id,$current_max_batch);
            }



            $seeds_namespace = vh_theme_database_seeder($item->name);
            Migration::runSeeds($seeds_namespace);

            //copy assets to public folder
            static::copyAssets($item);

        }


        // check if any theme is marked as default
        $is_default_exist = self::where('is_default', 1)->exists();

        if($is_default || !$is_default_exist)
        {
            $item->is_default = 1;

            //mark all other themes no none default
            Theme::where('is_default', 1)->update(['is_default'=>null]);
        }

        $item->is_active = 1;
        $item->is_assets_published = 1;

        $item->save();

        $response['success'] = true;
        $response['data'][] = '';
        $response['messages'][] = 'Theme is activated';

        if(env('APP_DEBUG'))
        {
            $response['hint'][] = '';
        }
        return $response;

    }
    //-------------------------------------------------
    public static function runMigrations($slug, $is_default=false)
    {
        try {
            $item = static::slug($slug)->first();

            if(!isset($item->is_migratable) || (isset($item->is_migratable) && $item->is_migratable == true))
            {

                $path = vh_theme_migrations_path($item->name);

                $max_batch = \DB::table('migrations')
                    ->max('batch');

                Migration::runMigrations($path);

                $current_max_batch = \DB::table('migrations')
                    ->max('batch');

                if($current_max_batch > $max_batch){
                    Migration::syncThemeMigrations($item->id,$current_max_batch);
                }

            }


            $response['success'] = true;
            $response['data'][] = '';
            $response['messages'][] = 'Migration run is successful';

            if(env('APP_DEBUG'))
            {
                $response['hint'][] = '';
            }
        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();

        }

        return $response;

    }
    //-------------------------------------------------
    public static function runSeeds($slug, $is_default=false)
    {
        try {
            $item = static::slug($slug)->first();

            if(!isset($item->is_migratable) || (isset($item->is_migratable) && $item->is_migratable == true))
            {

                $seeds_namespace = vh_theme_database_seeder($item->name);
                Migration::runSeeds($seeds_namespace);


                //delete all database migrations
                $theme_migrations = $item->migrations()->get()
                    ->pluck('migration_id')->toArray();

                if($theme_migrations)
                {
                    \DB::table('migrations')->whereIn('id', $theme_migrations)->delete();
                    Migration::whereIn('migration_id', $theme_migrations)->delete();
                }

                $max_batch = \DB::table('migrations')
                    ->max('batch');

                Migration::syncThemeMigrations($item->id,$max_batch);

            }

            $response['success'] = true;
            $response['data'][] = '';
            $response['messages'][] = 'Seeds run is successful';

            if(env('APP_DEBUG'))
            {
                $response['hint'][] = '';
            }
        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();

        }

        return $response;

    }
    //-------------------------------------------------
    public static function refreshMigrations($slug)
    {

        try{

            $item = static::where('slug',$slug)->first();

            if(!isset($item->is_migratable) || (isset($item->is_migratable) && $item->is_migratable == true))
            {
                $path = vh_theme_migrations_path($item->name);
                Migration::refreshMigrations($path);

                //delete all database migrations
                $theme_migrations = $item->migrations()->get()->pluck('migration_id')->toArray();

                if($theme_migrations)
                {
                    \DB::table('migrations')->whereIn('id', $theme_migrations)->delete();
                    Migration::whereIn('migration_id', $theme_migrations)->delete();
                }

                $max_batch = \DB::table('migrations')
                    ->max('batch');

                Migration::syncThemeMigrations($item->id,$max_batch);

            }

            $response['success'] = true;
            $response['data'][] = '';
            $response['messages'][] = 'Migration refresh is successful';

        }catch(\Exception $e)
        {
            $response['success'] = false;
            $response['errors'][] = $e->getMessage();

        }


        return $response;

    }
    //-------------------------------------------------
    public static function deactivateItem($slug)
    {
        $item = static::slug($slug)->first();
        $item->is_active = null;
        $item->save();
        $response['success'] = true;
        $response['data'][] = '';
        $response['messages'][] = trans('vaahcms-general.action_successful');
        if(env('APP_DEBUG'))
        {
            $response['hint'][] = '';
        }
        return $response;
    }
    //-------------------------------------------------
    public static function makeItemAsDefault($slug)
    {

        //make all themes as not default
        static::whereNotNull('is_default')->update(['is_default' => null]);

        $item = static::slug($slug)->first();
        $item->is_default = 1;
        $item->save();
        $response['success'] = true;
        $response['data'][] = '';
        $response['messages'][] = trans('vaahcms-general.action_successful');
        if(env('APP_DEBUG'))
        {
            $response['hint'][] = '';
        }
        return $response;
    }
    //-------------------------------------------------
    public static function deleteItem($slug)
    {

        try{

            $item = static::where('slug', $slug)->first();


            $item_path = config('vaahcms.themes_path')."/".$item->name;

            //Delete all migrations
            $path =  $item_path . "/Database/Migrations/";

            $migrations = vh_get_all_files($path);

            if(count($migrations) > 0)
            {
                foreach($migrations as $migration)
                {
                    $migration_path = $path.$migration;
                    include_once ($migration_path);
                    $migration_class = vh_get_class_from_file($migration_path);
                    if($migration_class)
                    {
                        $migration_obj = new $migration_class;
                        $migration_obj->down();
                    }
                }
            }

            //Delete theme settings
            $item->settings()->delete();

            //delete all database migrations
            $theme_migrations = $item->migrations()->get()->pluck('migration_id')->toArray();

            if($theme_migrations)
            {
                \DB::table('migrations')->whereIn('id', $theme_migrations)->delete();
                Migration::whereIn('migration_id', $theme_migrations)->delete();
            }

            $item->is_active = 0;
            $item->save();


            //delete theme folder
            vh_delete_folder($item_path);

            //Delete theme entry
            static::where('slug', $item->slug)->forceDelete();

            $response['success'] = true;
            $response['data'][] = '';
            $response['messages'][] = trans('vaahcms-general.action_successful');
            if(env('APP_DEBUG'))
            {
                $response['hint'][] = '';
            }
            return $response;

        }catch(\Exception $e)
        {
            $response['success'] = false;
            $response['errors'][] = $e->getMessage();

        }


        return $response;

    }
    //-------------------------------------------------
    public static function getOfficialDetails($slug)
    {

        try{
            $api = config('vaahcms.api_route')."theme/by/slug/".$slug;

            $api_response = @file_get_contents($api);

            if(!isset($api_response) || empty($api_response))
            {
                $response['success'] = false;
                $response['data']['url'] = $api;
                $response['errors'][] = 'API Response Error.';
                return $response;
            }

            $api_response = json_decode($api_response, true);


            if(!isset($api_response) || !isset($api_response['success'])
                || !$api_response['success'])
            {
                $response['success'] = false;
                $response['data']['url'] = $api;
                $response['data']['data'] = $api_response;
                $response['errors'][] = 'API Response Error.';


                return $response;

            } else if(isset($api_response['success']) && $api_response['success'])
            {
                return $api_response;
            } else
            {
                $response['success'] = false;
                $response['data']['url'] = $api;
                $response['data']['data'] = $api_response;
                $response['errors'][] = 'Unknown Error.';
            }


        }catch(\Exception $e)
        {
            $response['success'] = false;
            $response['errors'][] = $e->getMessage();
            return $response;
        }




    }
    //-------------------------------------------------
    public static function download($name, $download_link)
    {

        //check if theme is already installed
        $vaahcms_path = config('vaahcms.themes_path').'/';
        //$vaahcms_path = base_path('Download/Themes').'/';

        $package_path = $vaahcms_path.$name;

        if(is_dir($package_path))
        {
            $response['success'] = true;
            $response['data'] = [];
            $response['messages'][] = $name." theme already exist.";
            return $response;
        }

        $zip_file = $package_path.".zip";

        copy($download_link, $zip_file);

        try{
            $zip = new Zip;
            $zip->check($zip_file);
            $zip = $zip->open($zip_file);
            $zip_content_list = $zip->listFiles();
            $zip->extract($vaahcms_path);
            $zip->close();

            if (strpos($download_link, 'github.com') !== false) {
                $extracted_folder_name = $zip_content_list[0];
                rename($vaahcms_path.$extracted_folder_name, $package_path);
            }

            vh_delete_folder($zip_file);

            $response['success'] = true;
            $response['data'] = [];
            $response['messages'][] = $name." theme is installed.";
            return $response;

        }catch(\Exception $e)
        {
            $response['success'] = false;
            $response['errors'][] = $e->getMessage();
            return $response;
        }

    }

    //-------------------------------------------------
    public static function installUpdates($request)
    {

        $name = $request->name;
        $download_link = $request->download_link;

        $vaahcms_path = config('vaahcms.themes_path').'/';

        $item = static::where('name', $name)->first();


        $package_path = $vaahcms_path.$name;

        $zip_file = $package_path.".zip";

        copy($download_link, $zip_file);

        try{
            (new Zip)->check($zip_file);
            $zip = (new Zip)->open($zip_file);
            $zip_content_list = $zip->listFiles();
            $zip->extract($vaahcms_path);
            $zip->close();

            if (strpos($download_link, 'github.com') !== false) {
                $extracted_folder_name = $zip_content_list[0];
                File::copyDirectory($vaahcms_path.$extracted_folder_name, $package_path);
            }

            vh_delete_folder($vaahcms_path.$extracted_folder_name);
            vh_delete_folder($zip_file);

            //if the theme is active then run migration & seeds
            if($item->is_active)
            {
                static::activateItem($item->slug);
            }


            $item->is_update_available = null;
            $item->save();

            $response['success'] = true;
            $response['data'] = [];
            $response['messages'][] = $name." theme is updated.";
            return $response;

        }catch(\Exception $e)
        {
            $response['success'] = false;
            $response['errors'][] = $e->getMessage();
            return $response;
        }

    }
    //-------------------------------------------------
    public static function importSampleData($slug)
    {
        try{
            $item = static::slug($slug)->first();

            $command = 'db:seed';
            $params = [
                '--force' => true,
                '--class' => config('vaahcms.root_folder')."\Themes\\{$item->name}\\Database\Seeds\SampleDataTableSeeder"
            ];

            \Artisan::call($command, $params);

            $response['success'] = true;
            $response['messages'][] = 'Sample Data Successfully Imported';
        }catch(\Exception $e)
        {
            $response['success'] = false;
            $response['errors'][] = $e->getMessage();
        }


        return $response;

    }
    //-------------------------------------------------
    public static function storeUpdates($request)
    {
        $updates = 0;
        if(count($request->themes) > 0 )
        {
            foreach ($request->themes as $theme)
            {
                $store = static::where('slug', $theme['slug'])->first();

                if($store->version_number < $theme['version_number'])
                {
                    $store->is_update_available = 1;
                    $store->save();
                    $updates++;
                }

            }
        }

        $response['success'] = true;
        $response['data'][] = '';
        if($updates > 0)
        {
            $response['messages'][] = 'New updates are available for '.$updates.' theme(s).';
        } else{
            $response['messages'][] = 'No new update available.';
        }
        if(env('APP_DEBUG'))
        {
            $response['hint'][] = '';
        }
        return $response;

    }
    //-------------------------------------------------
    public static function bulkStatusChange($request)
    {


        if(!$request->has('inputs'))
        {
            $response['success'] = false;
            $response['errors'][] = 'Select IDs';
            return $response;
        }

        if(!$request->has('data'))
        {
            $response['success'] = false;
            $response['errors'][] = 'Select Status';
            return $response;
        }

        foreach($request->inputs as $id)
        {
            $item = static::find($id);
            if($request->data['status'] == 1)
            {
                static::activateItem($item->slug);
            }

            $item->status = $request->data['status'];
            $item->save();
        }

        $response['success'] = true;
        $response['data'] = [];
        $response['messages'][] = trans('vaahcms-general.action_successful');

        return $response;


    }
    //-------------------------------------------------
    public static function copyAssets($theme)
    {
        $path = config('vaahcms.themes_path').'/'.$theme->name;
        $source = $path."/Resources/assets";

        if(!\File::exists($source)) {
            return false;
        }

        $dec = public_path('vaahcms/themes/'.$theme->slug.'/assets');

        if(!\File::exists($dec)) {
            \File::makeDirectory($dec, 0755, true, true);
        }

        \File::copyDirectory($source, $dec);

        return true;
    }
    //-------------------------------------------------
}
