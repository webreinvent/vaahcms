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
    //-------------------------------------------------

}
