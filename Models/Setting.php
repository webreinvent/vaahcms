<?php namespace WebReinvent\VaahCms\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use WebReinvent\VaahCms\Models\User;
use WebReinvent\VaahCms\Traits\CrudWithUuidObservantTrait;

class Setting extends Model {

    use SoftDeletes;
    use CrudWithUuidObservantTrait;
    //-------------------------------------------------
    protected $connection= 'mysql';
    //-------------------------------------------------
    protected $table = 'vh_settings';
    //-------------------------------------------------
    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
        'settingable_id', 'settingable_type',
        'category', 'label', 'excerpt',
        'type', 'key', 'value', 'meta',
        'vh_user_id',"created_by",
        "updated_by","deleted_by"
    ];

    //-------------------------------------------------



    //-------------------------------------------------
    protected function serializeDate(DateTimeInterface $date)
    {
        $date_time_format = config('settings.global.datetime_format');

        return $date->format($date_time_format);

    }

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

    public function createdByUser()
    {
        return $this->belongsTo(User::class,
            'created_by', 'id'
        )->select('id', 'uuid', 'first_name', 'last_name', 'email');
    }

    //-------------------------------------------------
    public function updatedByUser()
    {
        return $this->belongsTo(User::class,
            'updated_by', 'id'
        )->select('id', 'uuid', 'first_name', 'last_name', 'email');
    }

    //-------------------------------------------------
    public function deletedByUser()
    {
        return $this->belongsTo(User::class,
            'deleted_by', 'id'
        )->select('id', 'uuid', 'first_name', 'last_name', 'email');
    }

    //-------------------------------------------------
    public function user()
    {
        return $this->belongsTo(User::class,
            'vh_user_id', 'id'
        )->select('id', 'uuid', 'first_name', 'last_name', 'email');
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
