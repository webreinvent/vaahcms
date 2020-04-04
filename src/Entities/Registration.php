<?php namespace WebReinvent\VaahCms\Entities;

use Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Traits\CrudWithUuidObservantTrait;


class Registration extends Model
{
    use Notifiable;
    use SoftDeletes;
    use CrudWithUuidObservantTrait;

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
        "uuid", "email","username","password",
        "display_name","title","first_name","middle_name","last_name",
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
    public function setBirthAttribute($value)
    {
        $this->attributes['birth'] = Carbon::parse($value)->format('Y-m-d');
    }
    //-------------------------------------------------
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::make($value);
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
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()
            ->getColumnListing($this->getTable());
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
    public static function create($request)
    {
        $inputs = $request->new_item;

        $rules = array(
            'email' => 'required|email',
            'first_name' => 'required',
            'password' => 'required',
        );

        $validator = \Validator::make( $inputs, $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }

        // check if already exist
        $user = static::where('email',$inputs['email'])->first();

        if($user)
        {
            $response['status'] = 'failed';
            $response['errors'][] = "This email is already registered.";
            return $response;
        }

        // check if user already exist
        $user = User::where('email',$inputs['email'])->first();

        if($user)
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'User already exist';
            if(env('APP_DEBUG'))
            {
                $response['hint'][] = 'Registration can be created only when user does not exist';
            }
            return $response;
        }

        if(!isset($inputs['username']))
        {
            $inputs['username'] = Str::slug($inputs['email']);
        }

        if(!isset($inputs['status']))
        {
            $inputs['status'] = 'email-verification-pending';
        }

        $inputs['created_ip'] = request()->ip();

        $reg = new static();
        $reg->fill($inputs);
        $reg->save();

        $response['status'] = 'success';
        $response['data']['item'] = $reg;
        return $response;

    }
    //-------------------------------------------------
    public static function getList($request)
    {
        $list = Registration::orderBy('created_at', 'DESC');

        if($request->has('trashed') && $request->trashed == true)
        {
            $list->withTrashed();
        }

        if($request->has('status') && !empty( $request->status))
        {
            $list->where('status', $request->status);
        }

        if($request->has("q"))
        {
            $list->where(function ($q) use ($request){
                $q->where('first_name', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('last_name', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('middle_name', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('email', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('id', '=', $request->q);
            });
        }

        $list = $list->paginate(config('vaahcms.per_page'));

        $response['status'] = 'success';
        $response['data']['list'] = $list;

        return $response;

    }
    //-------------------------------------------------
    public static function getItem($request)
    {

        $item = Registration::where('id', $request->id);
        $item->withTrashed();
        $item->with(['createdByUser', 'updatedByUser', 'deletedByUser']);
        $item = $item->first();

        $response['status'] = 'success';
        $response['data']['item'] = $item;

        return $response;

    }
    //-------------------------------------------------
    public static function store($request)
    {
        $rules = array(
            'id' => 'required',
            'email' => 'required|email',
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

        $item = Registration::where('id', $request->id)
            ->withTrashed()->first();

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

        if(!$request->has('activation_code'))
        {
            $item->activation_code = str_random(40);
        }

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
            $reg->status = $request->data['status'];
            $reg->save();
        }

        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = 'Action was successful';

        return $response;


    }
    //-------------------------------------------------
    public static function bulkTrash($request)
    {

        if(!$request->has('inputs'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Select IDs';
            return $response;
        }


        foreach($request->inputs as $id)
        {
            $reg = Registration::withTrashed()->where('id', $id)->first();
            if($reg)
            {
                $reg->delete();
            }
        }

        $response['status'] = 'success';
        $response['data'] = [];
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

        foreach($request->inputs as $id)
        {
            $reg = Registration::withTrashed()->where('id', $id)->first();
            if(isset($reg) && isset($reg->deleted_at))
            {
                $reg->restore();
            }
        }

        $response['status'] = 'success';
        $response['data'] = [];
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


        foreach($request->inputs as $id)
        {
            $reg = Registration::where('id', $id)->withTrashed()->first();
            if($reg)
            {
                $reg->forceDelete();
            }
        }

        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = 'Action was successful';

        return $response;


    }
    //-------------------------------------------------
    public static function sendVerificationEmail($request)
    {

        if(!$request->has('inputs'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Select IDs';
            return $response;
        }

        foreach($request->inputs as $id)
        {
            $reg = Registration::where('id', $id)->withTrashed()->first();
            if($reg)
            {
                $reg->activation_code = Str::uuid();
                $reg->activation_code_sent_at = \Carbon::now();
                $reg->save();
            }
        }

        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = 'Action was successful';

        return $response;

    }
    //-------------------------------------------------
}
