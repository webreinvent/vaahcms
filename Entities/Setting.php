<?php namespace WebReinvent\VaahCms\Entities;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model {

    //-------------------------------------------------
    protected $table = 'vh_settings';
    //-------------------------------------------------
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
        'settingable_id',
        'settingable_type',
        'category',
        'label',
        'excerpt',
        'type',
        'key',
        'value',
        'meta',
    ];

    //-------------------------------------------------

    protected $casts = [
        "created_at" => 'date:Y-m-d H:i:s',
        "updated_at" => 'date:Y-m-d H:i:s',
    ];

    //-------------------------------------------------
    public function getValueAttribute($value) {

        if(isset($this->type) && ($this->type == 'json' || $this->type == 'meta_tags'))
        {
            return json_decode($value);
        }

        return $value;
    }
    //-------------------------------------------------
    public function setValueAttribute($value) {
        if(is_array($value))
        {
            $this->attributes['value'] = json_encode($value);
        } else{
            $this->attributes['value'] = $value;
        }
    }
    //-------------------------------------------------
    public function scopeKey( $query, $key ) {
        return $query->where( 'key', $key );
    }

    //-------------------------------------------------
    public function settingable()
    {
        return $this->morphTo();
    }
    //-------------------------------------------------
    public static function getGlobalSettings($request)
    {

        $global_settings = Setting::where('category', 'global')
            ->get()
            ->pluck('value', 'key' )
            ->toArray();

        return $global_settings;

    }
    //-------------------------------------------------
    public static function getGlobalLinks($request)
    {

        $global_settings = Setting::where('category', 'global')
            ->where('type', 'link')
            ->get();

        return $global_settings;

    }
    //-------------------------------------------------
    public static function getGlobalScripts($request)
    {

        $global_settings = Setting::where('category', 'global')
            ->where('type', 'script')
            ->get()->pluck('value', 'key' )
            ->toArray();;

        return $global_settings;

    }
    //-------------------------------------------------
    public static function getGlobalMetaTags($request)
    {

        $global_settings = Setting::where('category', 'global')
            ->where('type', 'meta_tags')
            ->get();

        return $global_settings;

    }
    //-------------------------------------------------
    //-------------------------------------------------

}
