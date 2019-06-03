<?php namespace WebReinvent\VaahCms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Registration extends Model
{

    use Notifiable;

    use SoftDeletes;
    //-------------------------------------------------
    protected $table = 'vh_registrations';
    //-------------------------------------------------
    protected $dates = [
        "activation_code_sent_at",  "invited_at", "user_created_at",

        "created_at","updated_at","deleted_at"
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
        "uid","email","title","first_name","middle_name","last_name","username","password",
        "gender","country_calling_code","phone","timezone","alternate_email",
        "avatar_url","birth", "country","country_code",
        "country_calling_code","activation_code", "activation_code_sent_at",
        "activated_ip","invited_by", "invited_at","user_id",
        "user_created_at","meta",

        "created_ip","created_by", "updated_by","deleted_by"
    ];
    //-------------------------------------------------
    protected $hidden = [
        'password',
    ];

    //-------------------------------------------------

    //-------------------------------------------------
    protected $appends  = [

    ];

    //-------------------------------------------------

    //-------------------------------------------------
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucfirst($value);
    }
    //-------------------------------------------------
    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucfirst($value);
    }
    //-------------------------------------------------
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }
    //-------------------------------------------------

    //-------------------------------------------------

    //-------------------------------------------------
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
    //-------------------------------------------------
    public function scopeUsername($query, $username)
    {
        return $query->where('username', $username);
    }

    //-------------------------------------------------
    public function scopeEmail($query, $email)
    {
        return $query->where('email', $email);
    }

    //-------------------------------------------------
    public function scopeActivatedBetween($query, $from, $to)
    {
        return $query->whereBetween('activated_at', array($from, $to));
    }

    //-------------------------------------------------
    public function scopeCreatedBy($query, $user_id)
    {
        return $query->where('created_by', $user_id);
    }

    //-------------------------------------------------
    public function scopeUpdatedBy($query, $user_id)
    {
        return $query->where('updated_by', $user_id);
    }

    //-------------------------------------------------
    public function scopeDeletedBy($query, $user_id)
    {
        return $query->where('deleted_by', $user_id);
    }

    //-------------------------------------------------
    public function scopeCreatedBetween($query, $from, $to)
    {
        return $query->whereBetween('created_at', array($from, $to));
    }

    //-------------------------------------------------
    public function scopeUpdatedBetween($query, $from, $to)
    {
        return $query->whereBetween('updated_at', array($from, $to));
    }

    //-------------------------------------------------
    public function scopeDeletedBetween($query, $from, $to)
    {
        return $query->whereBetween('deleted_at', array($from, $to));
    }


    //-------------------------------------------------

    //-------------------------------------------------
    public function createdBy()
    {
        return $this->belongsTo('WebReinvent\VaahCms\Entities\User',
            'created_by', 'id'
        );
    }

    //-------------------------------------------------
    public function updatedBy()
    {
        return $this->belongsTo('WebReinvent\VaahCms\Entities\User',
            'updated_by', 'id'
        );
    }

    //-------------------------------------------------
    public function deletedBy()
    {
        return $this->belongsTo('WebReinvent\VaahCms\Entities\User',
            'deleted_by', 'id'
        );
    }

    //-------------------------------------------------
    public static function findByUsername($username, $columns = array('*'))
    {
        if ( ! is_null($user = static::whereUsername($username)->first($columns))) {
            return $user;
        } else
        {
            return false;
        }

    }
    //-------------------------------------------------
    public static function findByEmail($email, $columns = array('*'))
    {
        if ( ! is_null($user = static::whereEmail($email)->first($columns))) {
            return $user;
        }else
        {
            return false;
        }
    }

    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
}
