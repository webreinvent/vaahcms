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
    public function getValueAttribute($value) {

        if(isset($this->type) && $this->type == 'json')
        {
            return json_decode($value);
        }

        return $value;
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
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------

}
