<?php namespace WebReinvent\VaahCms\Entities;

use Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use WebReinvent\VaahCms\Traits\CrudWithUidObservantTrait;


class Registration extends Model
{
    use Notifiable;
    use SoftDeletes;
    use CrudWithUidObservantTrait;

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
        "uid","email","username","password","display_name","title","first_name","middle_name","last_name",
        "gender","country_calling_code","phone","timezone","alternate_email",
        "avatar_url","birth", "country","country_code", "status",
        "activation_code", "activation_code_sent_at",
        "activated_ip","invited_by", "invited_at","user_id",
        "user_created_at", "created_ip", "meta",
        "created_by", "updated_by","deleted_by"
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
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()
            ->getColumnListing($this->getTable());
    }
    //-------------------------------------------------
    public function getFormFillableColumns()
    {
        $list = [
            'email', 'username', 'password', 'display_name',
            'title', 'first_name', 'middle_name', 'last_name',
            'gender', 'country_calling_code', 'phone', 'timezone',
            'alternate_email', 'avatar_url', 'birth', 'country',
            'status', 'invited_by',
            'user_id',
            ];

        return $list;
    }
    //-------------------------------------------------
    public function getFormColumns($auto_fill=false)
    {
        $columns = $this->getFormFillableColumns();

        $result = [];
        $i = 0;

        foreach ($columns as $column)
        {
            $result[$i] = $this->getFormElement($column, $auto_fill);
            $i++;
        }

        return $result;
    }
    //-------------------------------------------------
    public function getFormElement($column, $auto_fill)
    {

        $result['name'] = $column;
        $result['label'] = slug_to_str($column);
        $result['column_type'] = $this->getConnection()->getSchemaBuilder()
            ->getColumnType($this->getTable(), $column);


        switch($column)
        {
            //------------------------------------------------
            case 'title':
                $result['type'] = 'select';
                $result['inputs'] = vh_name_titles();
                break;
            //------------------------------------------------
            case 'gender':
                $result['type'] = 'select';
                $result['inputs'] = vh_genders();
                break;
            //------------------------------------------------
            case 'country_calling_code':
                $result['type'] = 'select';
                $result['inputs'] = vh_get_countries_calling_codes();
                break;
            //------------------------------------------------
            case 'timezone':
                $result['type'] = 'select';
                $result['inputs'] = vh_get_timezones();
                break;
            //------------------------------------------------
            case 'birth':
                $result['type'] = 'date';
                $result['label'] = 'Birth Date';
                break;
            //------------------------------------------------
            case 'status':
                $result['type'] = 'select';
                $result['inputs'] = vh_registration_statuses();
                break;
            //------------------------------------------------
            case 'country':
                $result['type'] = 'select';
                $result['inputs'] = vh_get_country_list_with_slugs();
                break;
            //------------------------------------------------
            case 'invited_by':
                $result['type'] = 'select_with_ids';
                $result['inputs'] = User::getUsersForAssets();
                $result['label'] = "Invited By";
                break;
            //------------------------------------------------
            case 'user_id':
                $result['type'] = 'select_with_ids';
                $result['inputs'] = User::getUsersForAssets();
                $result['label'] = "Registration belongs to:";
                break;
            //------------------------------------------------
            case 'password':
                $result['type'] = 'password';
                break;
            //------------------------------------------------
            default:
                $result['type'] = 'text';
                break;
            //------------------------------------------------
        }

        return $result;
    }
    //-------------------------------------------------
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucfirst($value);
    }
    //-------------------------------------------------
    public function setMiddleNameAttribute($value)
    {
        $this->attributes['middle_name'] = ucfirst($value);
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
    public static function store($request)
    {
        $rules = array(
            'email' => 'required|email',
            'password' => 'required',
            'first_name' => 'required',
            'status' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }

        $data = [];

        if($request->has('id'))
        {
            $reg = Registration::find($request->id);
        } else
        {
            $validation = static::registrationValidation($request);
            if(isset($validation['status']) && $validation['status'] == 'failed')
            {
                return $validation;
            } else if(isset($validation['status']) && $validation['status'] == 'registration-exist')
            {
                $reg = $validation['data'];
            } else
            {
                $reg = new Registration();
            }
        }

        $reg->fill($request->all());
        $reg->password = Hash::make($request->password);

        if($request->has('invited_by') && !$request->has('invited_at'))
        {
            $reg->invited_at = \Carbon::now();
        }

        if($request->has('user_id') && !$request->has('user_created_at'))
        {
            $reg->user_created_at = \Carbon::now();
            $reg->created_ip = $request->ip();
        }

        if($request->has('user_id') && !$request->has('user_created_at'))
        {
            $reg->user_created_at = \Carbon::now();
            $reg->created_ip = $request->ip();
        }

        $reg->activation_code = str_random(40);

        if($request->has('user_id') && !$request->has('activated_at'))
        {
            $reg->activated_at = \Carbon::now();
            $reg->activated_ip = $request->ip();
        }

        $reg->save();

        $response['status'] = 'success';
        $response['messages'][] = 'Saved';
        $response['data'] = $reg;

        return $response;


    }
    //-------------------------------------------------
    public static function registrationValidation($request)
    {

        //check if user already exist with the emails
        $user = User::where('email', $request->email)->first();
        if($user)
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Email is already registered.';
            return $response;
        }

        //check if user already exist with the phone
        if($request->has('country_calling_code') && $request->has('phone'))
        {
            $user = User::where('country_calling_code', $request->country_calling_code)
                ->where('phone', $request->phone)
                ->first();

            if($user)
            {
                $response['status'] = 'failed';
                $response['errors'][] = 'Phone number is already registered.';
                return $response;
            }
        }

        //if status is registered then user_id is required
        if($request->has('status') && $request->status == 'registered' && !$request->has('user_id'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'The registration status is "registered", hence user id is required';
            return $response;
        }

        //check if registration record exist
        $reg_by_email = Registration::findByEmail($request->email);
        if($reg_by_email)
        {
            $response['status'] = 'registration-exist';
            $response['data'] = $reg_by_email;
            return $response;
        }

        $reg_by_phone = Registration::where('country_calling_code', $request->country_calling_code)
            ->where('phone', $request->phone)
            ->first();
        if($reg_by_phone)
        {
            $response['status'] = 'registration-exist';
            $response['data'] = $reg_by_phone;
            return $response;
        }


    }
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
}
