<?php namespace WebReinvent\VaahCms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleSetting extends Model {

    use SoftDeletes;
    //-------------------------------------------------
    protected $table = 'vh_module_settings';
    //-------------------------------------------------
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
        'module_id',
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
    public function module() {
        return $this->belongsTo( 'WebReinvent\VaahCms\Entities\Module',
            'module_id', 'id'
        );
    }
    //-------------------------------------------------

}
