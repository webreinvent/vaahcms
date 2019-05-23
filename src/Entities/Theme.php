<?php namespace WebReinvent\VaahCms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    public static function syncModule($path)
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

        $module = Theme::firstOrCreate(['slug' => $settings['slug']]);
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

        foreach ($other_settings as $key => $setting)
        {
            $where_con = [
                'module_id' => $module->id,
                'key'   => $key
            ];


            $module_setting = ModuleSetting::firstOrCreate($where_con);
            if(is_array($setting) || is_object($setting))
            {
                $module_setting->type = 'json';
                $module_setting->value = json_encode($setting);
            } else
            {
                $module_setting->value = $setting;
            }

            $module_setting->save();
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
    //-------------------------------------------------

}
