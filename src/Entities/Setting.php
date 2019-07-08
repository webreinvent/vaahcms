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
        'label',
        'excerpt',
        'type',
        'key',
        'value',
    ];

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

}
