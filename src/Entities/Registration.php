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
        "activation_code_sent_at", "activated_at",  "invited_at", "user_created_at",
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
        'name'
    ];

    //-------------------------------------------------

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
    public function getNameAttribute() {
        return $this->first_name." ".$this->last_name;
    }
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
    public function getFormColumns()
    {
        $columns = $this->getFormFillableColumns();

        $result = [];
        $i = 0;

        foreach ($columns as $column)
        {
            $result[$i] = $this->getFormElement($column);
            $i++;
        }

        return $result;
    }
    //-------------------------------------------------
    public function getFormElement($column, $value=null)
    {

        $result['name'] = $column;
        $result['value'] = $value;
        $result['tr_class'] = "";
        $result['disabled'] = false;
        $result['label'] = slug_to_str($column);
        $result['column_type'] = $this->getConnection()->getSchemaBuilder()
            ->getColumnType($this->getTable(), $column);


        switch($column)
        {
            //------------------------------------------------
            case 'id':
            case 'uid':
                $result['type'] = 'text';
                $result['disabled'] = true;
                $result['tr_class'] = 'tr__disabled';
                break;
            //------------------------------------------------
            case 'created_by':
                $result['type'] = 'select_with_ids';
                $result['inputs'] = User::getUsersForAssets();
                break;
            //------------------------------------------------
            case 'updated_by':
            case 'deleted_by':
            case 'meta':
            case 'created_ip':
            case 'activated_ip':
            case 'activation_code_sent_at':
            case 'user_created_at':
            case 'deleted_at':
            case 'updated_at':
            case 'created_at':
            case 'invited_at':
            case 'activated_at':
            case 'activation_code':
                $result['type'] = 'hidden';
                break;
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
            'first_name' => 'required',
            'status' => 'required',
        );

        if(!$request->has('id'))
        {
            $rules['password'] = 'required';
        }

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
            $item = Registration::find($request->id);
        } else
        {
            $validation = static::registrationValidation($request);
            if(isset($validation['status']) && $validation['status'] == 'failed')
            {
                return $validation;
            } else if(isset($validation['status']) && $validation['status'] == 'registration-exist')
            {
                $item = $validation['data'];
            } else
            {
                $item = new Registration();
            }
        }

        $item->fill($request->all());
        if($request->has('password'))
        {
            $item->password = Hash::make($request->password);
        }

        if($request->has('invited_by') && !$request->has('invited_at'))
        {
            $item->invited_at = \Carbon::now();
        }

        if($request->has('user_id') && !$request->has('user_created_at'))
        {
            $item->user_created_at = \Carbon::now();
            $item->created_ip = $request->ip();
        }

        if($request->has('user_id') && !$request->has('user_created_at'))
        {
            $item->user_created_at = \Carbon::now();
            $item->created_ip = $request->ip();
        }

        $item->activation_code = str_random(40);

        if($request->has('user_id') && !$request->has('activated_at'))
        {
            $item->activated_at = \Carbon::now();
            $item->activated_ip = $request->ip();
        }

        $item->save();

        $response['status'] = 'success';
        $response['messages'][] = 'Saved';
        $response['data'] = $item;

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
    public function recordForFormElement()
    {
        $record = $this->toArray();

        $columns = $this->getFormFillableColumns();

        $visible = ['id', 'uid'];

        $columns = array_merge($visible, $columns);

        $result = [];
        $i = 0;

        foreach ($columns as $column)
        {
            if(isset($record[$column]))
            {
                $result[$i] = $this->getFormElement($column, $record[$column]);
                $i++;
            }

        }


        return $result;
    }
    //-------------------------------------------------
    public static function bulkStatusChange($request)
    {

        if(!$request->has('inputs'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Select IDs';
            return $response;
        }

        if(!$request->has('data'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Select Status';
            return $response;
        }

        foreach($request->inputs as $id)
        {
            $reg = Registration::find($id);
            $reg->status = $request->data;
            $reg->save();
        }

        $response['status'] = 'success';
        $response['messages'][] = 'Action was successful';

        return $response;


    }
    //-------------------------------------------------
    public static function bulkDelete($request)
    {

        if(!$request->has('inputs'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Select IDs';
            return $response;
        }

        if(!$request->has('data'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Select Status';
            return $response;
        }

        foreach($request->inputs as $id)
        {
            $reg = Registration::find($id);
            if($reg)
            {
                $reg->delete();
            }
        }

        $response['status'] = 'success';
        $response['messages'][] = 'Action was successful';

        return $response;


    }
    //-------------------------------------------------
    public static function bulkRestore($request)
    {

        if(!$request->has('inputs'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Select IDs';
            return $response;
        }

        if(!$request->has('data'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Select Status';
            return $response;
        }

        foreach($request->inputs as $id)
        {
            $reg = Registration::withTrashed()->where('id', $id)->first();
            if(isset($reg) && isset($reg->deleted_at))
            {
                $reg->restore();
            }
        }

        $response['status'] = 'success';
        $response['messages'][] = 'Action was successful';

        return $response;


    }
    //-------------------------------------------------
}
