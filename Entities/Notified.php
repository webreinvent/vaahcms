<?php namespace WebReinvent\VaahCms\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Notified extends Model {

    use SoftDeletes;

    //-------------------------------------------------
    protected $table = 'vh_notified';
    //-------------------------------------------------
    protected $dates = [
        'last_attempt_at',
        'sent_at',
        'read_at',
        'marked_delivered',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
        'vh_notification_id',
        'vh_user_id',
        'via',
        'last_attempt_at',
        'sent_at',
        'read_at',
        'marked_delivered',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    //-------------------------------------------------
    protected $appends  = [
    ];

    //-------------------------------------------------

    protected $casts = [
        "last_attempt_at" => 'date:Y-m-d H:i:s',
        "sent_at" => 'date:Y-m-d H:i:s',
        "read_at" => 'date:Y-m-d H:i:s',
        "marked_delivered" => 'date:Y-m-d H:i:s',
        "created_at" => 'date:Y-m-d H:i:s',
        "updated_at" => 'date:Y-m-d H:i:s',
        "deleted_at" => 'date:Y-m-d H:i:s'
    ];
    //-------------------------------------------------
    public function __construct(array $attributes = [])
    {
        $date_time_format = config('settings.global.datetime_format');
        if(is_array($this->casts) && isset($date_time_format))
        {
            foreach ($this->casts as $date_key => $format)
            {
                $this->casts[$date_key] = 'date:'.$date_time_format;
            }
        }
        parent::__construct($attributes);
    }
    //-------------------------------------------------
    public function setMetaAttribute($value) {
        $this->attributes['meta'] = json_encode($value);
    }
    //-------------------------------------------------
    public function getMetaAttribute($value) {
        return json_decode($value);
    }
    //-------------------------------------------------
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()
            ->getColumnListing($this->getTable());
    }
    //-------------------------------------------------
    public function scopeExclude($query, $columns)
    {
        return $query->select( array_diff( $this->getTableColumns(),$columns) );
    }
    //-------------------------------------------------
    public function createdByUser()
    {
        return $this->belongsTo('WebReinvent\VaahCms\Entities\User',
            'created_by', 'id'
        )->select('id', 'uuid', 'first_name', 'last_name', 'email');
    }
    //-------------------------------------------------
    public function updatedByUser()
    {
        return $this->belongsTo('WebReinvent\VaahCms\Entities\User',
            'updated_by', 'id'
        )->select('id', 'uuid', 'first_name', 'last_name', 'email');
    }
    //-------------------------------------------------
    public function deletedByUser()
    {
        return $this->belongsTo('WebReinvent\VaahCms\Entities\User',
            'deleted_by', 'id'
        )->select('id', 'uuid', 'first_name', 'last_name', 'email');
    }
    //-------------------------------------------------
    public static function viaBackend($user=null)
    {
        if(!$user)
        {
            $user = \Auth::user();
        }

        $list = static::where('via', 'backend')
            ->where('vh_user_id', $user->id);

        $list->whereNull('marked_delivered');

        $list = $list->take(3)->get();

        return $list;

    }
    //-------------------------------------------------
    //-------------------------------------------------


}
