<?php namespace WebReinvent\VaahCms\Models;

use DateTimeInterface;
use Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Models\Registration;
use WebReinvent\VaahCms\Notifications\Notice;


use WebReinvent\VaahCms\Traits\CrudWithUuidObservantTrait;


class RegistrationBase extends Model
{
    use Notifiable;
    use SoftDeletes;
    use CrudWithUuidObservantTrait;

    //-------------------------------------------------
    protected $connection= 'mysql';
    //-------------------------------------------------
    protected $table = 'vh_registrations';
    //-------------------------------------------------
    protected $casts = [
        "activation_code_sent_at"  => 'datetime',
        "activated_at"  => 'datetime',
        "invited_at"  => 'datetime',
        "user_created_at"  => 'datetime',
        "created_at"  => 'datetime',
        "updated_at"  => 'datetime',
        "deleted_at"  => 'datetime'
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
        "uuid", "email","username","password","display_name",
        "title","designation","first_name","middle_name","last_name",
        "gender","country_calling_code","phone", "bio","timezone",
        "alternate_email","avatar_url","birth", "country","country_code",
        "status","activation_code", "activation_code_sent_at",
        "activated_ip","invited_by", "invited_at",
        "invited_for_key", "invited_for_value", "vh_user_id",
        "user_created_at", "created_ip", "meta",
        "created_by", "updated_by","deleted_by"

    ];
    //-------------------------------------------------
    protected $hidden = [
        'password',
    ];

    //-------------------------------------------------

    //-------------------------------------------------
    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }
    //-------------------------------------------------
    protected $appends  = [
        'name'
    ];

    //-------------------------------------------------
    protected function serializeDate(DateTimeInterface $date)
    {
        $date_time_format = config('settings.global.datetime_format');

        return $date->format($date_time_format);

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
    public function setMetaAttribute($value)
    {
        $this->attributes['meta'] = json_encode($value);
    }
    //-------------------------------------------------
    public function getMetaAttribute($value)
    {
        if($value && $value!='null'){
            return json_decode($value);
        }else{
            return json_decode('{}');
        }
    }
    //-------------------------------------------------
    public function getNameAttribute() {

        if($this->display_name)
        {
            return $this->display_name;
        }

        $name = $this->first_name;

        if($this->middle_name)
        {
            $name .= " ".$this->middle_name;
        }

        if($this->last_name)
        {
            $name .= " ".$this->last_name;
        }

        return $name;
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
    public function scopeBetweenDates($query, $from, $to)
    {

        if($from)
        {
            $from = Carbon::parse($from)
                ->startOfDay()
                ->toDateTimeString();
        }

        if($to)
        {
            $to = Carbon::parse($to)
                ->endOfDay()
                ->toDateTimeString();
        }

        $query->whereBetween('created_at',[$from,$to]);
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
    public function belongable()
    {
        return $this->morphTo();
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
    public function invitedByUser()
    {
        return $this->belongsTo(User::class,
            'invited_by', 'id'
        )->select('id', 'uuid', 'first_name', 'last_name', 'email');
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
            'email' => 'required|email|max:150',
            'first_name' => 'required|max:150',
            'password' => 'required',
        );

        $validator = \Validator::make( $inputs, $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }

        // check if already exist
        $user = static::where('email',$inputs['email'])->first();

        if($user)
        {
            $response['success'] = false;
            $response['messages'][] = trans('vaahcms-user.email_already_registered');
            return $response;
        }

        // check if username already exist
        $user = self::where('username',$inputs['username'])->first();

        if($user)
        {
            $response['success'] = false;
            $response['messages'][] = trans('vaahcms-user.username_already_registered');
            return $response;
        }

        // check if user already exist
        $user = User::where('email',$inputs['email'])->first();

        if($user)
        {
            $response['success'] = false;
            $response['messages'][] = 'User already exist';
            if(env('APP_DEBUG'))
            {
                $response['hint'][] = trans('vaahcms-user.registration_created_when_user_not_exist');
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


        $response['success'] = true;
        $response['data']['item'] = $reg;
        $response['messages'][] = trans('vaahcms-general.saved_successfully');
        return $response;

    }

    //-------------------------------------------------

    public static function createRegistration($request)
    {

        $inputs = $request->all();

           $rules = [
                      'username' => 'required|max:150',
                      'email' => 'email:rfc',
                      'password' => 'required',
                      'confirm_password' => 'required|same:password',
                   ];

           $messages = [
                       'confirm_password.same' => 'Password and confirm password does not match.',
                 ];

            $validator = \Validator::make($request->all(), $rules, $messages);

        if ( $validator->fails() ) {
            $errors = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }

        // check if email already exist
        $user = static::where('email',$inputs['email'])->first();

        if($user)
        {
            $response['success'] = false;
            $response['messages'][] = trans('vaahcms-user.email_already_registered');
            return $response;
        }

        // check if username already exist
        $user = self::where('username',$inputs['username'])->first();

        if($user)
        {
            $response['success'] = false;
            $response['messages'][] = trans('vaahcms-user.username_already_registered');
            return $response;
        }

        // check if user already exist
        $vh_user = User::where('email',$inputs['email'])->first();
        if($vh_user)
        {
            $response['success'] = false;
            $response['messages'][] = 'User already exist';
            if(env('APP_DEBUG'))
            {
                $response['hint'][] = trans('vaahcms-user.registration_created_when_user_not_exist');
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

        $request_item = new Request([$reg->id]);

        Registration::sendVerificationEmail($request_item);
        $redirect_url = \URL::route('vh.backend');
        $response['success'] = true;
        $response['data']['item'] = $reg;
        $response['messages'][] = trans('vaahcms-general.saved_successfully');
        $response['data']['redirect_url'] = $redirect_url;
        return $response;

    }

    //-------------------------------------------------
    public static function getList($request,$excluded_columns = [])
    {

        $list = Registration::orderBy('created_at', 'DESC');

        if($request->has('trashed') && $request->trashed == 'true')
        {
            $list->withTrashed();
        }

        if(isset($request->from) && isset($request->to))
        {
            $list->betweenDates($request['from'],$request['to']);
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
                    ->orWhere('display_name', 'LIKE', '%'.$request->q.'%')
                    ->orWhere(\DB::raw('concat(first_name," ",middle_name," ",last_name)'), 'like', '%'.$request['q'].'%')
                    ->orWhere(\DB::raw('concat(first_name," ",last_name)'), 'like', '%'.$request['q'].'%')
                    ->orWhere('email', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('id', '=', $request->q);
            });
        }

        if(!\Auth::user()->hasPermission('can-see-users-contact-details')){
            $list->exclude(array_merge(['email','alternate_email', 'phone'],$excluded_columns));
        }else{
            $list->exclude($excluded_columns);
        }


        if(isset($request['per_page'])
            && $request['per_page']
            && is_numeric($request['per_page'])){
            $list = $list->paginate($request['per_page']);
        }else{
            $list = $list->paginate(config('vaahcms.per_page'));
        }

        $response['success'] = true;
        $response['data']['list'] = $list;

        return $response;

    }
    //-------------------------------------------------
    public static function getItem($request,$excluded_columns = [])
    {

        $item = Registration::where('id', $request->id);
        $item->withTrashed();
        $item->with(['createdByUser', 'updatedByUser', 'deletedByUser']);

        if(!\Auth::user()->hasPermission('can-see-users-contact-details')){
            $item->exclude(array_merge(['email','alternate_email', 'phone'],$excluded_columns));
        }else{
            $item->exclude($excluded_columns);
        }

        $item = $item->first();


        $response['success'] = true;
        $response['data']['item'] = $item;

        return $response;

    }
    //-------------------------------------------------
    public static function postStore($request)
    {

        $rules = array(
            'id' => 'required',
            'email' => 'required|email|max:150',
            'first_name' => 'required|max:150',
            'status' => 'required',
        );

        if($request->has('username'))
        {
            $rules['username'] = 'alpha_dash|max:15';
        }

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }

        //check if user already exist with the emails
        $user = Registration::where('id','!=',$request->id)
            ->where('email', $request->email)->first();
        if($user)
        {
            $response['success'] = false;
            $response['messages'][] = 'This email is already registered.';
            return $response;
        }

        // check if already exist
        $user = self::where('id', '!=', $request->id)
            ->where('username',$request->username)->first();

        if($user)
        {
            $response['success'] = false;
            $response['messages'][] = trans('vaahcms-user.username_already_registered');
            return $response;
        }

        $item = Registration::where('id', $request->id)
            ->withTrashed()->first();

        $item->fill($request->all());

        if($request->has('password'))
        {
            $item->password = $request->password;
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
            $item->activation_code = Str::random(40);
        }

        if($request->has('user_id') && !$request->has('activated_at'))
        {
            $item->activated_at = \Carbon::now();
            $item->activated_ip = $request->ip();
        }

        $item->save();

        $response['success'] = true;
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
            $response['success'] = false;
            $response['messages'][] = 'Email is already registered.';
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
                $response['success'] = false;
                $response['messages'][] = 'Phone number is already registered.';
                return $response;
            }
        }

        //if status is registered then user_id is required
        if($request->has('status') && $request->status == 'registered' && !$request->has('user_id'))
        {
            $response['success'] = false;
            $response['messages'][] = 'The registration status is "registered", hence user id is required';
            return $response;
        }

        //check if registration record exist
        $reg_by_email = Registration::findByEmail($request->email);

        if($reg_by_email) {
            $response['status'] = 'registration-exist';
            $response['data'] = $reg_by_email;
            return $response;
        }

        $reg_by_phone = Registration::where('country_calling_code', $request->country_calling_code)
            ->where('phone', $request->phone)
            ->first();
        if ($reg_by_phone) {
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
            $response['success'] = false;
            $response['messages'][] = 'Select IDs';
            return $response;
        }

        if(!$request->has('data'))
        {
            $response['success'] = false;
            $response['messages'][] = 'Select Status';
            return $response;
        }

        foreach($request->inputs as $id)
        {
            $reg = Registration::find($id);
            $reg->status = $request->data['status'];
            $reg->save();
        }

        $response['success'] = true;
        $response['data'] = [];
        $response['messages'][] = trans('vaahcms-general.action_successful');

        return $response;


    }
    //-------------------------------------------------
    public static function bulkTrash($request)
    {

        if(!$request->has('inputs'))
        {
            $response['success'] = false;
            $response['messages'][] = 'Select IDs';
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

        $response['success'] = true;
        $response['data'] = [];
        $response['messages'][] = trans('vaahcms-general.action_successful');

        return $response;


    }
    //-------------------------------------------------
    public static function bulkRestore($request)
    {

        if(!$request->has('inputs'))
        {
            $response['success'] = false;
            $response['messages'][] = 'Select IDs';
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

        $response['success'] = true;
        $response['data'] = [];
        $response['messages'][] = trans('vaahcms-general.action_successful');

        return $response;


    }
    //-------------------------------------------------
    public static function bulkDelete($request)
    {

        if(!$request->has('inputs'))
        {
            $response['success'] = false;
            $response['messages'][] = 'Select IDs';
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

        $response['success'] = true;
        $response['data'] = [];
        $response['messages'][] = trans('vaahcms-general.action_successful');

        return $response;


    }
    //-------------------------------------------------
    public static function sendVerificationEmail($request)
    {

        if(!$request->has('inputs'))
        {
            $response['success'] = false;
            $response['messages'][] = 'Select IDs';
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

        $response['success'] = true;
        $response['data'] = [];
        $response['messages'][] = trans('vaahcms-general.action_successful');

        return $response;

    }
    //-------------------------------------------------
    public static function createUser($request,$id)
    {

        $reg = static::where('id',$id)->withTrashed()->first();

        if(!$reg){
            $response['success'] = false;
            $response['messages'][] = 'Registration does not exist exist.';
            return $response;
        }

        $reg->makeVisible('password');

        // check if User of this Email Id is already exist
        $user_exist = User::where('email',$reg['email'])->first();

        if($user_exist)
        {
            $response['success'] = false;
            $response['messages'][] = "User of this Email Id is already exist.";
            return $response;
        }

        $user = new User();

        // For Ignore Password Mutator
        $user->prevent_password_hashing = true;

        $req_array = $reg->toArray();

        if(!$req_array['country_calling_code']){
            $req_array['country_calling_code'] = null;
        }

        $user->fill($req_array);
        $user->password = $reg->password;
        $user->registration_id = $reg->id;
        $user->status = 'active';
        $user->is_active = 1;
        $user->save();

        $reg->vh_user_id = $user->id;
        $reg->status = 'user-created';
        $reg->save();

        if($request->has('can_send_mail') && $request->can_send_mail){
            $notification = Notification::where('slug', "send-welcome-email")->first();
            $inputs = [
                "user_id" => $user->id,
                "notification_id" => $notification->id,
            ];

            $user->notify(new Notice($notification, $inputs));
        }

        $response['success'] = true;
        $response['data']['user'] = $user;
        $response['messages'][] = 'User is created.';

        return $response;

    }
    //-------------------------------------------------
}
