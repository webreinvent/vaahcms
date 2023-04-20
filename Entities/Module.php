<?php namespace WebReinvent\VaahCms\Entities;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
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
        'is_migratable',
        'is_assets_published',
        'is_sample_data_available',
        'is_update_available',
        'update_checked_at',
    ];

    //-------------------------------------------------



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
        return $this->morphMany(Setting::class, 'settingable');
    }
    //-------------------------------------------------
    public function migrations()
    {
        return $this->morphMany(Migration::class, 'migrationable');
    }
    //-------------------------------------------------
    public static function getItem($id)
    {
        try {
            $item = static::where('id', $id)
                ->withTrashed()
                ->first();

            $response['status'] = 'success';
            $response['data'] = $item;
        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();

        }


        return $response;

    }
    //-------------------------------------------------
    public static function syncModule($module_path)
    {

        $settings = vh_get_module_settings_from_path($module_path);

        if(is_null($settings) || !is_array($settings) || count($settings) < 1)
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Fatal with '.$module_path.'\Config\config.php';
            return $response;
        }

        $rules = array(
            'name' => 'required',
            'title' => 'required',
            'slug' => 'required',
            'thumbnail' => 'required',
            'excerpt' => 'required',
            //'download_link' => 'required',
            'author_name' => 'required',
            'author_website' => 'required',
            'version' => 'required',
        );

        $validator = \Validator::make( $settings, $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
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

            $setting = $module->settings()->where('key', $key)->first();

            if(!$setting)
            {
                $setting = new Setting($setting_data);
                $module->settings()->save($setting);
            }

        }

        $module = Module::where('slug', $module->slug)->with(['settings'])->first();

        return $module;


    }
    //-------------------------------------------------
    public static function syncAllModules()
    {

        $list = vh_get_all_modules_paths();

        $installed = static::orderBy('name', 'asc')->get()
            ->pluck('name')->toArray();



        if($installed && count($list) < 1)
        {
            foreach ($installed as $item)
            {
                $installed_module = static::where('name', $item)->first();
                $installed_module->forceDelete();
            }
        }


        if(count($list) < 1)
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans('vaahcms-general.no_module_installed');
            return $response;
        }

        $installed_module_names = [];

        if(count($list) > 0)
        {
            foreach ($list as $module_path)
            {
                $installed_module_names[] = basename($module_path);
            }
        }

        //remove database records if module folder does not exist
        if(count($installed_module_names) > 0)
        {
            foreach ($installed as $item)
            {
                if(!in_array($item, $installed_module_names))
                {
                    $installed_module = static::where('name', $item)->first();
                    $installed_module->forceDelete();
                }
            }

        }



        foreach($list as $module_path)
        {
            $res = Module::syncModule($module_path);
        }

    }
    //-------------------------------------------------
    public static function getInstalledModules()
    {
        $list = Model::all();
        return $list;
    }
    //-------------------------------------------------
    public static function getActiveModules()
    {
        return static::where('is_active', 1)->get();
    }

    //-------------------------------------------------
    public static function validateDependencies($dependencies)
    {
        try {
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
                                    $response['errors'][] = "Please install and activate '".$dependency_slug."' module.";
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
                    case 'themes':

                        if(is_array($dependency_list))
                        {
                            foreach ($dependency_list as $dependency_slug)
                            {
                                $theme = Theme::slug($dependency_slug)->first();

                                if(!$theme)
                                {
                                    $response['status'] = 'failed';
                                    $response['errors'][] = "Please install and activate '".$dependency_slug."' theme.";
                                }

                                if($theme && $theme->is_active != 1)
                                {
                                    $response['status'] = 'failed';
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
        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();

        }

        return $response;
    }
    //-------------------------------------------------

    //-------------------------------------------------
    public static function publishAssets($slug)
    {
        try {
            $module = Module::slug($slug)->first();

            //copy assets to public folder
            Module::copyAssets($module);

            $module->is_assets_published = 1;
            $module->save();

            $response['status'] = 'success';
            $response['data']['item'] = $module;
            $response['messages'][] = 'Assets is published';

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

    //-------------------------------------------------
    public static function activateItem($slug)
    {
        try {
            $module = Module::slug($slug)->first();

            /*
             * get module dependencies
             */
            $response = vh_module_action($module->name, 'SetupController@dependencies');


            if($response['status'] == 'failed')
            {
                return $response;
            }

            /*
             * check module dependencies are installed
             */
            $response = Module::validateDependencies($response['data']);


            if(isset($response['status']) && $response['status'] == 'failed')
            {
                return $response;
            }



            if(!isset($module->is_migratable) || (isset($module->is_migratable) && $module->is_migratable == true))
            {
                $module_path = config('vaahcms.modules_path').$module->name;
                $path = vh_module_migrations_path($module->name);

                $max_batch = \DB::table('migrations')
                    ->max('batch');

                Migration::runMigrations($path);

                $current_max_batch = \DB::table('migrations')
                    ->max('batch');

                if($current_max_batch > $max_batch){
                    Migration::syncModuleMigrations($module->id,$current_max_batch);
                }

                $seeds_namespace = vh_module_database_seeder($module->name);
                Migration::runSeeds($seeds_namespace);

                //copy assets to public folder
                Module::copyAssets($module);

            }

            $module->is_active = 1;
            $module->is_assets_published = 1;
            $module->save();

            $response['status'] = 'success';
            $response['data']['item'] = $module;
            $response['messages'][] = 'Module is activated';

            if(env('APP_DEBUG'))
            {
                $response['hint'][] = '';
            }
        } catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();

        }

        return $response;

    }
    //-------------------------------------------------
    public static function deactivateItem($slug)
    {
        try {
            $item = static::slug($slug)->first();
            $item->is_active = null;
            $item->save();
            $response['status'] = 'success';
            $response['data']['item'] = $item;
            $response['messages'][] = trans('vaahcms-general.action_successful');
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
    public static function runModuleMigrations($slug)
    {
        try{
            $module = Module::slug($slug)->first();

            if(!isset($module->is_migratable) || (isset($module->is_migratable) && $module->is_migratable == true))
            {
                $module_path = config('vaahcms.modules_path').$module->name;
                $path = vh_module_migrations_path($module->name);

                $max_batch = \DB::table('migrations')
                    ->max('batch');

                Migration::runMigrations($path);

                $current_max_batch = \DB::table('migrations')
                    ->max('batch');

                if($current_max_batch > $max_batch){
                    Migration::syncModuleMigrations($module->id,$current_max_batch);
                }

            }


            $response['status'] = 'success';
            $response['data']['item'] = $module;
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
    public static function runModuleSeeds($slug)
    {
        try{
            $module = Module::slug($slug)->first();

            if(!isset($module->is_migratable) || (isset($module->is_migratable) && $module->is_migratable == true))
            {

                $seeds_namespace = vh_module_database_seeder($module->name);
                Migration::runSeeds($seeds_namespace);

            }


            $response['status'] = 'success';
            $response['data']['item'] = $module;
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
    public static function deleteItem($slug)
    {

        try{

            $item = static::where('slug', $slug)->first();


            $item_path = config('vaahcms.modules_path')."/".$item->name;

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

            //Delete module settings
            $item->settings()->delete();

            //delete all database migrations
            $module_migrations = $item->migrations()->get()->pluck('migration_id')->toArray();

            if($module_migrations)
            {
                \DB::table('migrations')->whereIn('id', $module_migrations)->delete();
                Migration::whereIn('migration_id', $module_migrations)->delete();
            }

            $item->is_active = 0;
            $item->save();


            //delete module folder
            vh_delete_folder($item_path);

            //Delete module entry
            static::where('slug', $item->slug)->forceDelete();

            $response['status'] = 'success';
            $response['data']['item'] = $item;
            $response['messages'][] = trans('vaahcms-general.action_successful');
            if(env('APP_DEBUG'))
            {
                $response['hint'][] = '';
            }
            return $response;

        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();

        }


        return $response;

    }
    //-------------------------------------------------
    public static function resetModuleMigrations($slug)
    {

        try{

            $module = Module::slug($slug)->first();

            if(!isset($module->is_migratable) || (isset($module->is_migratable) && $module->is_migratable == true))
            {

                $module_path = config('vaahcms.modules_path').$module->name;
                $path = vh_module_migrations_path($module->name);
                Migration::refreshtMigrations($path);

            }

            $response['status'] = 'success';
            $response['data']['item'] = $module;
            $response['messages'][] = 'Migration refresh is successful';
        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();

        }


        return $response;

    }
    //-------------------------------------------------
    public static function copyAssets($module)
    {
        $module_path = config('vaahcms.modules_path').'/'.$module->name;
        $source = $module_path."/Resources/assets";
        $dec = public_path('vaahcms/modules/'.$module->slug.'/assets');

        if(!\File::exists($source)) {
            return false;
        }

        if(!\File::exists($dec)) {
            \File::makeDirectory($dec, 0755, true, true);
        }

        \File::copyDirectory($source, $dec);

        return true;
    }
    //-------------------------------------------------
    public static function getOfficialDetails($slug)
    {

        try{
            $api = config('vaahcms.api_route')."module/by/slug/".$slug;

            $api_response = @file_get_contents($api);

            if(!isset($api_response) || empty($api_response))
            {
                $response['status'] = 'failed';
                $response['data']['url'] = $api;
                $response['errors'][] = 'API Response Error.';
                return $response;
            }

            $api_response = json_decode($api_response, true);


            if(!isset($api_response) || !isset($api_response['status']) || $api_response['status'] != 'success')
            {
                $response['status'] = 'failed';
                $response['data']['url'] = $api;
                $response['data']['data'] = $api_response;
                $response['errors'][] = 'API Response Error.';


                return $response;

            } else if($api_response['status'] == 'success')
            {
                return $api_response;
            } else
            {
                $response['status'] = 'failed';
                $response['data']['url'] = $api;
                $response['data']['data'] = $api_response;
                $response['errors'][] = 'Unknown Error.';
            }


        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
            return $response;
        }




    }
    //-------------------------------------------------
    public static function download($name, $download_link)
    {

        //check if module is already installed
        $vaahcms_path = config('vaahcms.modules_path').'/';
        //$vaahcms_path = base_path('Download/Modules').'/';

        $package_path = $vaahcms_path.$name;

        if(is_dir($package_path))
        {
            $response['status'] = 'success';
            $response['data'] = [];
            $response['messages'][] = $name." module already exist.";
            return $response;
        }

        $zip_file = $package_path.".zip";

        copy($download_link, $zip_file);

        try{
            Zip::check($zip_file);
            $zip = Zip::open($zip_file);
            $zip_content_list = $zip->listFiles();
            $zip->extract($vaahcms_path);
            $zip->close();

            if (strpos($download_link, 'github.com') !== false) {
                $extracted_folder_name = $zip_content_list[0];
                rename($vaahcms_path.$extracted_folder_name, $package_path);
            }

            vh_delete_folder($zip_file);

            $response['status'] = 'success';
            $response['data'] = [];
            $response['messages'][] = $name." module is installed.";
            return $response;

        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
            return $response;
        }

    }
    //-------------------------------------------------
    public static function installUpdates($request)
    {

        $name = $request->name;
        $download_link = $request->download_link;

        $vaahcms_path = config('vaahcms.modules_path').'/';

        $module = static::where('name', $name)->first();


        $package_path = $vaahcms_path.$name;

        $zip_file = $package_path.".zip";

        copy($download_link, $zip_file);

        try{
            Zip::check($zip_file);
            $zip = Zip::open($zip_file);
            $zip_content_list = $zip->listFiles();
            $zip->extract($vaahcms_path);
            $zip->close();

            if (strpos($download_link, 'github.com') !== false) {
                $extracted_folder_name = $zip_content_list[0];
                File::copyDirectory($vaahcms_path.$extracted_folder_name, $package_path);
            }

            vh_delete_folder($vaahcms_path.$extracted_folder_name);
            vh_delete_folder($zip_file);

            //if the modules is active then run migration & seeds
            if($module->is_active)
            {
                static::activateItem($module->slug);
            }


            $module->is_update_available = null;
            $module->save();

            $response['status'] = 'success';
            $response['data'] = [];
            $response['messages'][] = $name." module is updated.";
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
        try{
            $module = Module::slug($slug)->first();

            $command = 'db:seed';
            $params = [
                '--class' => config('vaahcms.root_folder')."\Modules\\{$module->name}\\Database\Seeds\SampleDataTableSeeder"
            ];

            \Artisan::call($command, $params);

            $response['status'] = 'success';
            $response['data']['item'] = $module;
            $response['messages'][] = 'Sample Data Successfully Imported';
        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
        }


        return $response;

    }
    //-------------------------------------------------
    public static function storeUpdates($request)
    {
        try {
            $updates = 0;
            if(count($request->modules) > 0 )
            {
                foreach ($request->modules as $module)
                {
                    $store_modules = static::where('slug', $module['slug'])->first();

                    if($store_modules->version_number < $module['version_number'])
                    {
                        $store_modules->is_update_available = 1;
                        $store_modules->save();
                        $updates++;
                    }

                }
            }

            $response['status'] = 'success';
            $response['data'][] = '';
            if($updates > 0)
            {
                $response['messages'][] = 'New updates are available for '.$updates.' modules.';
            } else{
                $response['messages'][] = 'No new update available.';
            }
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
    public static function bulkStatusChange($request)
    {

        try {
            if(!$request->has('inputs'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = 'Select IDs';
                return $response;
            }

            if(!$request->has('data'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = 'Select Status';
                return $response;
            }

            foreach($request->inputs as $id)
            {
                $item = static::find($id);
                if($request->data['status'] == 1)
                {
                    Module::activateItem($item->slug);
                }

                $item->status = $request->data['status'];
                $item->save();
            }

            $response['status'] = 'success';
            $response['data'] = [];
            $response['messages'][] = trans('vaahcms-general.action_successful');
        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();

        }

        return $response;


    }
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------

}
