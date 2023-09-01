<?php
namespace WebReinvent\VaahCms\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Lab404\Impersonate\Models\Impersonate;
use WebReinvent\VaahCms\Libraries\VaahMail;
use WebReinvent\VaahCms\Traits\CrudWithUuidObservantTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use WebReinvent\VaahCms\Mail\SecurityOtpMail;

class UserBase extends Authenticatable
{

    use Impersonate;
    use Notifiable;
    use SoftDeletes;
    use CrudWithUuidObservantTrait;

    //-------------------------------------------------
    protected $connection= 'mysql';
    //-------------------------------------------------
    protected $table = 'vh_users';
    public bool $prevent_password_hashing = false;
    //-------------------------------------------------
    //-------------------------------------------------
    protected $casts = [
        'security_code_expired_at' => 'datetime',
        'last_login_at' => 'datetime',
        'api_token_used_at' => 'datetime',
        'affiliate_code_used_at' => 'datetime',
        'reset_password_code_sent_at' => 'datetime',
        'reset_password_code_used_at' => 'datetime',
        'birth' => 'datetime',
        'activated_at' => 'datetime'
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
        "uuid","email","username","display_name","title","designation",
        "first_name","middle_name","last_name", "password",
        "gender","country_calling_code","phone", "bio",
        "website","timezone",
        "alternate_email","avatar_url","birth",
        "country","country_code","last_login_at","last_login_ip",
        "remember_token", "login_otp", "api_token","api_token_used_at",
        "api_token_used_ip","is_active","activated_at","status",
        "affiliate_code","affiliate_code_used_at","security_code_expired_at",
        "reset_password_code",'mfa_methods',"security_code",
        "reset_password_code_sent_at","reset_password_code_used_at",
        'foreign_user_id',"meta","created_ip","created_by",
        "updated_by","deleted_by"
    ];
    //-------------------------------------------------
    protected $hidden = [
        'password',
        'login_otp',
        'remember_token',
        'api_token',
        'api_token_used_at',
        'api_token_used_ip',
        'reset_password_code',
    ];

    //-------------------------------------------------
    protected $appends  = [
        'avatar', 'name'
    ];
    //-------------------------------------------------


    //-------------------------------------------------
    protected function serializeDate(DateTimeInterface $date)
    {
        $date_time_format = config('settings.global.datetime_format');

        return $date->format($date_time_format);

    }

    //-------------------------------------------------
    public function getAvatarAttribute() {

        if($this->avatar_url)
        {
            return asset($this->avatar_url);
        }

        $grav_url = vh_get_avatar_by_email($this->email);

        return $grav_url;
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
    public function setMfaMethodsAttribute($value)
    {
        $this->attributes['mfa_methods'] = json_encode($value);
    }
    //-------------------------------------------------
    public function getMfaMethodsAttribute($value)
    {
        if($value && $value!='null'){
            return json_decode($value);
        }else{
            return [];
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
    public function setFirstNameAttribute($value) {
        $this->attributes['first_name'] = ucfirst($value);
    }
    //-------------------------------------------------
    public function setMiddleNameAttribute($value) {
        $this->attributes['middle_name'] = ucfirst($value);
    }
    //-------------------------------------------------
    public function setLastNameAttribute($value) {
        $this->attributes['last_name'] = ucfirst($value);
    }
    //-------------------------------------------------
    public function setPasswordAttribute($value) {
        if ($this->prevent_password_hashing) {
            // Ignore Mutator
            $this->attributes['password'] = $value;
        } else {
            $this->attributes['password'] = Hash::make($value);
        }
    }
    //-------------------------------------------------
    public function setLoginOtpAttribute($value) {

        if(is_null($value) || empty($value))
        {
            $this->attributes['login_otp'] = null;
        } else{
            $this->attributes['login_otp'] = Hash::make($value);
        }
    }
    //-------------------------------------------------

    public function scopeIsActive($query)
    {
        $query->where('is_active', 1);
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
    public function getFormFillableColumns()
    {
        $list = [
            'email', 'username', 'password', 'display_name',
            'title', 'first_name', 'middle_name', 'last_name',
            'gender', 'country_calling_code', 'phone', 'timezone',
            'alternate_email', 'avatar_url', 'birth', 'country',
            'last_login_at', 'last_login_ip', 'api_token', 'api_token_used_at',
            'api_token_used_ip', 'is_active', 'activated_at', 'status',
            'affiliate_code', 'affiliate_code_used_at','security_code_expired_at',
            'security_code','created_by', 'updated_by',
            'deleted_by', 'created_at', 'updated_at',
            'deleted_at'
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
    public static function findByUsername($username, $columns = array('*'))
    {
        if ( ! is_null($user = self::whereUsername($username)->first($columns))) {
            return $user;
        } else
        {
            return false;
        }

    }
    //-------------------------------------------------
    public static function findByEmail($email, $columns = array('*'))
    {
        if ( ! is_null($user = self::whereEmail($email)->first($columns))) {
            return $user;
        }else
        {
            return false;
        }
    }

    //-------------------------------------------------
    public function roles()
    {
        return $this->belongsToMany(Role::class,
            'vh_user_roles', 'vh_user_id', 'vh_role_id'
        )->withPivot('is_active',
            'created_by',
            'created_at',
            'updated_by',
            'updated_at');
    }

    //-------------------------------------------------
    public function activeRoles()
    {
        return $this->roles()->wherePivot('is_active', 1);
    }
    //-------------------------------------------------
    public static function countSuperAdministrators()
    {
        $count = User::whereHas('roles', function ($query) {
            $query->where('vh_user_roles.is_active', '=', 1)
                ->slug('super-administrator');
        })->isActive()->get()->count();

        return $count;
    }

    //-------------------------------------------------
    //-------------------------------------------------
    public static function getByRoles($array_role_slugs)
    {

        $list = User::whereHas('roles', function ($query) use ($array_role_slugs)
        {
            if(count($array_role_slugs))
            {
                $i = 0;
                foreach ($array_role_slugs as $slug)
                {
                    if($i == 0)
                    {
                        $query->where('slug', $slug);
                    } else
                    {
                        $query->orWhere('slug', $slug);
                    }
                    $i++;
                }
            }

        })->with(['roles'])->where('is_active', 1)
            ->get();

        return $list;
    }
    //-------------------------------------------------
    public static function getByRolesOnlyIds($array_role_slugs)
    {
        $list = User::getByRoles($array_role_slugs)
            ->pluck('id')->toArray();
        return $list;
    }
    //-------------------------------------------------
    public static function getByRolesOnlyEmails($array_role_slugs)
    {
        $list = User::getByRoles($array_role_slugs)
            ->pluck('email')->toArray();
        return $list;
    }
    //-------------------------------------------------
    public function permissions($slugs_only=false)
    {
        $roles = $this->roles()->isActive()
            ->wherePivot('is_active', 1)->get();


        $permissions_list = array();
        foreach ($roles as $role) {

            if($role->slug !='super-administrator')
            {
                $permissions = $role->permissions()->isActive()
                    ->wherePivot('is_active', 1)->get();
            } else {
                $permissions = $role->permissions()->get();
            }

            foreach ($permissions as $permission) {

                if ($role->slug =='super-administrator') {
                    $permissions_list[$permission->id] = $permission->toArray();

                } else {
                    if (!$permission->is_active) {
                        continue;
                    }

                    $permissions_list[$permission->id] = $permission->toArray();
                }
            }
        }

        if ($slugs_only) {
            $permissions_list = collect($permissions_list)
                ->pluck('slug')->toArray();
        }

        return $permissions_list;
    }

    //-------------------------------------------------

    //-------------------------------------------------
    public static function rulesSuperAdminCreate()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:core_users|max:255',
            'mobile' => 'required|unique:core_users|max:10',
            'username' => 'unique:core_users|max:20',
            'password' => 'required|max:255',
        ];
        return $rules;
    }
    //-------------------------------------------------

    //-------------------------------------------------
    public static function userValidation($request)
    {

        //check if user already exist with the emails
        $user = self::where('email', $request->email)->first();
        if($user)
        {
            $response['success'] = false;
            $response['errors'][] = trans('vaahcms-user.email_already_registered');
            return $response;
        }

        //check if user already exist with the phone
        if($request->has('country_calling_code') && $request->has('phone'))
        {
            $user = self::where('country_calling_code', $request->country_calling_code)
                ->where('phone', $request->phone)
                ->first();

            if($user)
            {
                $response['success'] = false;
                $response['errors'][] = trans('vaahcms-user.phone_already_registered');
                return $response;
            }
        }

        //if status is registered then user_id is required
        if($request->has('status') && $request->status == 'registered' && !$request->has('user_id'))
        {
            $response['success'] = false;
            $response['errors'][] = trans('vaahcms-user.registration_status_is_registered');
            return $response;
        }

        //check if registration record exist
        $reg_by_email = self::findByEmail($request->email);
        if($reg_by_email)
        {
            $response['status'] = 'registration-exist';
            $response['data'] = $reg_by_email;
            return $response;
        }

        if($request->has('country_calling_code') && $request->has('phone')) {
            $reg_by_phone = self::where('country_calling_code', $request->country_calling_code)
                ->where('phone', $request->phone)
                ->first();

            if($reg_by_phone)
            {
                $response['status'] = 'registration-exist';
                $response['data'] = $reg_by_phone;
                return $response;
            }
        }

    }
    //-------------------------------------------------
    public static function isLastSuperAdmin()
    {
        $count = self::countSuperAdministrators();
        if($count < 2)
        {
            return true;
        }
        return false;
    }
    //-------------------------------------------------
    public static function restrictedActions($action_type, $user_id)
    {


        //restricted actions on logged in users
        $result = false;
        if($user_id === \Auth::user()->id)
        {
            switch ($action_type)
            {
                //------------------------
                case 'bulk-trash':
                case 'bulk-delete':
                case 'bulk-change-status':
                    $result = true;
                    break;
                //------------------------
                default:
                    break;
                //------------------------
            }

            return $result;
        }


        //restricted action if this user is last super admin
        $result = false;
        $user = self::find($user_id);
        $is_last_super_admin = self::isLastSuperAdmin();

        if($user->hasRole('super-administrator') && $is_last_super_admin)
        {
            switch ($action_type)
            {
                //------------------------
                case 'bulk-change-status':
                    $result = true;
                    break;
                //------------------------
                default:
                    break;
                //------------------------
            }

            return $result;
        }


        return $result;
    }
    //-------------------------------------------------
    public static function beforeUserActionValidation($request)
    {
        //check if already logged in
        if (\Auth::check())
        {
            \Auth::logout();
        }

        $rules = array(
            'email' => 'required|email|max:150',
        );
        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            $response['success'] = false;
            $response['errors'] = errorsToArray($validator->errors());
            return $response;
        }

        $inputs = $request->all();
        $inputs['email'] = trim($inputs['email']);

        $rules = array(
            'email' => 'required|email',
        );
        $validator = \Validator::make($inputs, $rules);

        if ($validator->fails())
        {
            $errors = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }

        $user = self::where('email', $inputs['email'])->first();

        //check user is active
        if(!$user)
        {
            $response['success'] = false;
            $response['errors'][] = trans('vaahcms-user.no_user_exist');
            return $response;
        }

        //check user is active
        if($user->is_active != 1)
        {
            $response['success'] = false;
            $response['errors'][] = trans('vaahcms::messages.inactive_account');
            return $response;
        }

        return $user;
    }
    //-------------------------------------------------
    public static function beforeUserLoginValidation($request)
    {
        //check if already logged in
        if (\Auth::check())
        {
            \Auth::logout();
        }

        $inputs = $request->all();
        $inputs['email'] = trim($inputs['email']);

        $rules = array(
            'email' => 'required|max:150',
        );
        $messages = array(
            'email.required' => trans('vaahcms-login.email_or_username_required'),
            'email.max' => trans('vaahcms-login.email_or_username_limit'),
        );
        $validator = \Validator::make($inputs, $rules, $messages);

        if ($validator->fails())
        {
            $errors = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }

        $user = self::where('email', $inputs['email'])->first();

        //check user is active
        if(!$user){
            $user = self::where('username', $inputs['email'])->first();
        }

        if(!$user)
        {
            $response['success'] = false;
            $response['errors'][] = trans('vaahcms-user.no_user_exist');
            return $response;
        }

        //check user is active
        if($user->is_active != 1)
        {
            $response['success'] = false;
            $response['errors'][] = trans('vaahcms::messages.inactive_account');
            return $response;
        }

        return $user;
    }
    //-------------------------------------------------

    public static function login($request, $permission_slug = null)
    {

        $user = self::beforeUserLoginValidation($request);

        if(isset($user['success']) && !$user['success'])
        {
            return $user;
        }

        if(isset($permission_slug) && !$user->hasPermission($permission_slug))
        {

            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

        $inputs = $request->all();

        $remember = false;
        if ($request->has("remember") || $request->get("remember") == "on") {
            $remember = true;
        }

        if (Auth::attempt(['email' => $inputs['email'],
            'password' => trim($request->get('password'))
        ], $remember))
        {

            $user = Auth::user();
            $user->last_login_at = Carbon::now();

            $user->save();

            $response['success'] = true;
        }elseif(Auth::attempt(['username' => $inputs['email'],
            'password' => trim($request->get('password'))
        ], $remember)){
            $user = Auth::user();
            $user->last_login_at = Carbon::now();
            $user->save();

            $response['success'] = true;
        } else {
            $response['success'] = false;
            $response['errors'][] = trans('vaahcms::messages.invalid_credentials');
        }

        return $response;
    }
    //-------------------------------------------------
    public static function sendLoginOtp($request, $permission_slug=null): array
    {
        $user = self::beforeUserActionValidation($request);
        if(isset($user['success']) && !$user['success'])
        {
            return $user;
        }

        if(isset($permission_slug) && !$user->hasPermission($permission_slug))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");
            return $response;
        }

        $otp_1 = mt_rand(100, 999);
        $otp_2 = mt_rand(100, 999);
        $otp = $otp_1.$otp_2;
        $user->login_otp = $otp;
        $user->save();

        $notification = Notification::where('slug', 'send-login-otp')
            ->first();

        $inputs = [
            'login_otp' => $otp,
            'notification_id' => $notification->id,
            'user_id' => $user->id,
        ];


        $response = Notification::dispatch($notification, $user, $inputs);

        if(isset($response['success']) && !$response['success'])
        {
            return $response;
        }

        $response['success'] = true;
        $response['messages'] = [
            trans('vaahcms-login.otp_sent')
        ];

        return $response;
    }
    //-------------------------------------------------
    public static function loginViaOtp($request, $permission_slug=null): array
    {

        $user = self::beforeUserActionValidation($request);

        if(isset($user['success']) && !$user['success'])
        {
            return $user;
        }

        if(isset($permission_slug) && !$user->hasPermission($permission_slug))
        {

            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

        $rules = array(
            'login_otp' => 'required|digits:6',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }


        /*if(count($request->login_otp) < 6
            || is_null($user->login_otp)
            || empty($user->login_otp)
        )
        {
            $response['success'] = false;
            $response['errors'][] = 'Invalid OTP';
            return $response;
        }

        $login_otp = implode('', $request->login_otp);*/
        $login_otp = $request->login_otp;
        $login_otp = trim($login_otp);

        if (Hash::check($login_otp, $user->login_otp))
        {
            if ($request->has("remember") || $request->get("remember") == "on") {
                Auth::login($user, true);
            } else{
                Auth::login($user);
            }

            $user->login_otp = null;
            $user->last_login_at = Carbon::now();
            $user->last_login_ip = request()->ip();
            $user->save();

            $response['success'] = true;
            $response['data'] = [];

        } else {
            $response['success'] = false;
            $response['errors'][] = trans('vaahcms::messages.invalid_credentials');
        }
        return $response;

    }
    //-------------------------------------------------
    public static function sendResetPasswordEmail($request, $permission_slug=null): array
    {

        $user = self::beforeUserActionValidation($request);
        if(isset($user['success']) && !$user['success'])
        {
            return $user;
        }

        if(isset($permission_slug) && !$user->hasPermission($permission_slug))
        {

            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

        $reset_password_code = uniqid();

        $user->reset_password_code = $reset_password_code;
        $user->reset_password_code_sent_at = Carbon::now();
        $user->save();

        $notification = Notification::where('slug', 'send-reset-password-email')
            ->first();

        $inputs = [
            'user_id' => $user->id,
            'notification_id' => $notification->id,
            'reset_password_code' => $reset_password_code,
        ];

        $request = new Request($inputs);


        $response = Notification::send($notification,$user,$request->all());

        if(isset($response['success']) && !$response['success'])
        {
            return $response;
        }

        $response['messages'] = [
            trans('vaahcms-login.reset_code_sent')
        ];

        return $response;

    }
    //-------------------------------------------------
    public static function resetPassword($request): array
    {

        $rules = array(
            'reset_password_code' => 'required',
            'password' => 'required|confirmed|min:6',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }

        $user = self::where('reset_password_code',$request->reset_password_code)->first();

        if(!$user)
        {
            $response['success'] = false;
            $response['errors'][] = trans('vaahcms-login.incorrect_reset_password_code');
            return $response;
        }

        $user->password = $request->password;
        $user->reset_password_code = null;
        $user->save();

        $response['success'] = true;
        $response['data'][] = '';
        $response['messages'][] = trans('vaahcms-login.password_has_been_reset');

        return $response;

    }
    //-------------------------------------------------
    public function hasRole($role_slug)
    {
        foreach ($this->roles()->wherePivot('is_active', 1)->get() as $role) {
            if ($role->slug == $role_slug)
            {
                return true;
            }
        }
        return false;
    }

    //-------------------------------------------------

    //-------------------------------------------------
    public function isSuperAdmin()
    {
        return $this->hasRole('super-administrator');
    }

    //-------------------------------------------------
    public function hasPermission($permission_slug, $details=false)
    {

        if ($this->isSuperAdmin()) {

            if($details)
            {
                $response['success'] = true;
                if(env('APP_DEBUG'))
                {
                    $response['data']['permission'] = 'Permission slug: '.$permission_slug;
                    $response['hint'][] = 'Super Admin has all permission by default.';
                }
                return $response;

            } else{
                return true;
            }

        }

        //check if permission exist or not
        $permission = Permission::where('slug', $permission_slug)
            ->first();

        if (!$permission)
        {
            if($details)
            {
                $response['success'] = false;
                $response['errors'][] = 'No Permission exist with slug: ' . $permission_slug;

                if (env('APP_DEBUG')) {
                    $response['hint'][] = 'Check the migrations & seeds are properly run.';
                }

                return $response;

            } else {
                return false;
            }
        }

        if ($permission->is_active != 1) {
            if($details)
            {
                $response['success'] = false;
                $response['errors'][] = $permission_slug.' is inactive';
                if(env('APP_DEBUG'))
                {
                    $response['hint'][] = 'Enable the permission status to active from
                    backend/admin control panel.';
                }
                return $response;

            } else{
                return false;
            }

        }

        foreach ($this->permissions() as $permission)
        {


            if ($permission['slug'] == $permission_slug
                && $permission['is_active'] == 1
                && $permission['pivot']['is_active'] == 1
            )
            {
                if($details)
                {
                    $response['success'] = true;
                    $response['data'] = [];
                    if(env('APP_DEBUG'))
                    {
                        $response['hint'][] = 'Permission slug: '.$permission_slug.'
                        is active for '.\Auth::user()->email;
                    }
                    return $response;

                } else{
                    return true;
                }
                break;
            }
        }

        if($details)
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");
            if(env('APP_DEBUG'))
            {
                $response['hint'][] = 'Permission slug: '.$permission_slug.' is not active
                for '.\Auth::user()->email;
            }
            return $response;

        } else{
            return false;
        }

    }

    //-------------------------------------------------


    //-------------------------------------------------

    //-------------------------------------------------
    public static function getAvatarById($id)
    {
        $user = self::find($id);
        return $user->thumbnail;
    }
    //-------------------------------------------------
    public static function notifySuperAdmins($subject, $message)
    {
        $users = self::getByRoles(['super-administrator']);

        if(count($users) < 0)
        {
            return false;
        }

        $to = [];

        foreach ($users as $user)
        {
            $item = ['email' => $user->email, 'name' => $user->name];
            $to[] = $item;
        }

        VaahMail::dispatchGenericMail($subject, $message, $to);

    }
    //-------------------------------------------------
    public static function getUsersForAssets()
    {

        $list = self::active()
            ->select('id', 'first_name', 'middle_name', 'last_name')
            ->get();

        return $list;

    }
    //-------------------------------------------------
    public static function createItem($request)
    {
        if (!\Auth::user()->hasPermission('can-create-users')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

        $inputs = $request->all();

        $validate = self::validation($inputs);

        if (isset($validate['success']) && !$validate['success']) {
            return $validate;
        }

        $rules = array(
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
        $user = self::withTrashed()->where('email',$inputs['email'])->first();

        if ($user) {
            $response['success'] = false;
            $response['errors'][] = trans('vaahcms-user.email_already_registered');
            return $response;
        }

        // check if username already exist
        $user = self::withTrashed()->where('username',$inputs['username'])->first();

        if ($user) {
            $response['success'] = false;
            $response['errors'][] = trans('vaahcms-user.username_already_registered');
            return $response;
        }

        if (!isset($inputs['username'])) {
            $inputs['username'] = Str::slug($inputs['email']);
        }

        if ($inputs['is_active'] === '1' || $inputs['is_active'] === 1 ) {
            $inputs['is_active'] = 1;
        } else {
            $inputs['is_active'] = 0;
        }

        $inputs['created_ip'] = request()->ip();

        $reg = new static();
        $reg->fill($inputs);
        $reg->save();

        Role::syncRolesWithUsers();

        $response['success'] = true;
        $response['data']['item'] = $reg;
        $response['messages'][] = trans('vaahcms-general.saved_successfully');
        return $response;

    }
    //-------------------------------------------------
    public function scopeGetSorted($query, $filter)
    {
        if( !isset($filter['sort'])) {
            return $query->orderBy('id', 'desc');
        }

        $sort = $filter['sort'];

        $direction = Str::contains($sort, ':');

        if (!$direction) {
            return $query->orderBy($sort, 'asc');
        }

        $sort = explode(':', $sort);

        return $query->orderBy($sort[0], $sort[1]);
    }
    //-------------------------------------------------
    public function scopeIsActiveFilter($query, $filter)
    {

        if (!isset($filter['is_active'])
            || is_null($filter['is_active'])
            || $filter['is_active'] === 'null'
        )
        {
            return $query;
        }

        $is_active = $filter['is_active'];

        if ($is_active === 'true' || $is_active === true) {
            return $query->whereNotNull('is_active');
        } else {
            return $query->whereNull('is_active');
        }
    }
    //-------------------------------------------------
    public function scopeTrashedFilter($query, $filter)
    {
        if (!isset($filter['trashed'])) {
            return $query;
        }

        $trashed = $filter['trashed'];

        if ($trashed === 'include') {
            return $query->withTrashed();
        } else if($trashed === 'only'){
            return $query->onlyTrashed();
        }
    }
    //-------------------------------------------------
    public function scopeSearchFilter($query, $filter)
    {
        if (!isset($filter['q'])) {
            return $query;
        }

        $search = $filter['q'];

        $query->where(function ($q) use ($search) {
            $q->where('first_name', 'LIKE', '%'. $search . '%')
                ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                ->orWhere('middle_name', 'LIKE', '%' . $search . '%')
                ->orWhere('display_name', 'LIKE', '%' . $search . '%')
                ->orWhere(\DB::raw('concat(first_name," ",middle_name," ",last_name)'), 'like', '%' . $search .'%')
                ->orWhere(\DB::raw('concat(first_name," ",last_name)'), 'like', '%'. $search .'%')
                ->orWhere('email', 'LIKE', '%' . $search .'%')
                ->orWhere('id', '=', $search);
        });
    }
    //-------------------------------------------------
    public static function getList($request,$excluded_columns = [])
    {
        if (isset($request['recount']) && $request['recount'] == true) {
            Role::syncRolesWithUsers();
        }

        $list = self::getSorted($request->filter);
        $list->isActiveFilter($request->filter);
        $list->trashedFilter($request->filter);
        $list->searchFilter($request->filter);

        if (isset($request['from']) && isset($request['to'])) {
            $list->betweenDates($request['from'],$request['to']);
        }

        $rows = config('vaahcms.per_page');

        if ($request->has('rows')) {
            $rows = $request->rows;
        }

        $list->withCount(['activeRoles']);

        $list = $list->paginate($rows);
        $countRole = Role::all()->count();

        $response['success'] = true;
        $response['data']['totalRole'] = $countRole;
        $response['data'] = $list;

        return $response;
    }
    //-------------------------------------------------
    public static function getItem($id,$excluded_columns = [])
    {

        $item = self::where('id', $id)->with(['createdByUser',
            'updatedByUser', 'deletedByUser'])
            ->withTrashed();

        if(!$item)
        {
            $response['success'] = false;
            $response['errors'][] = 'Record not found with ID: '.$id;
            return $response;
        }

        if (!\Auth::user()->hasPermission('can-see-users-contact-details')) {
            $item->exclude(array_merge(['email','alternate_email', 'phone'],$excluded_columns));
        } else {
            $item->exclude($excluded_columns);
        }

        $item = $item->first();

        $response['success'] = true;
        $response['data'] = $item;

        return $response;

    }
    //-------------------------------------------------
    public static function getItemRoles($request,$id)
    {
        $item = self::withTrashed()->where('id', $id)->first();

        $response['data']['item'] = $item;


        if($request->has("q"))
        {
            $list = $item->roles()->where(function ($q) use ($request){
                $q->where('name', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('slug', 'LIKE', '%'.$request->q.'%');
            });
        } else
        {
            $list = $item->roles();
        }

        $list->orderBy('pivot_is_active', 'desc');

        $list = $list->paginate(config('vaahcms.per_page'));


        foreach ($list as $role){

            $data = self::getPivotData($role->pivot);

            $role['json'] = $data;
            $role['json_length'] = count($data);
        }

        $response['data']['list'] = $list;
        $response['success'] = true;

        return $response;

    }

    //-------------------------------------------------
    public static function postStore($request)
    {

        $inputs = $request->all();

        $validate = self::validation($inputs);

        if(isset($validate['success']) && !$validate['success'])
        {
            return $validate;
        }

        if(isset($inputs['phone']))
        {
            $rules['phone'] = 'integer';

            $validator = \Validator::make( $request->all(), $rules);
            if ( $validator->fails() ) {

                $errors             = errorsToArray($validator->errors());
                $response['success'] = false;
                $response['errors'] = $errors;
                return $response;
            }
        }




        if($request->has('birth'))
        {
            $inputs['birth'] = Carbon::parse($request->birth)->format('Y-m-d');
        }

        if($request->has('id'))
        {

            // check if already exist
            $user = self::where('id', '!=', $inputs['id'])
                ->where('email',$inputs['email'])->first();

            if($user)
            {
                $response['success'] = false;
                $response['errors'][] = trans('vaahcms-user.email_already_registered');
                return $response;
            }
            // check if already exist
            $user = self::where('id', '!=', $inputs['id'])
                ->where('username',$inputs['username'])->first();

            if($user)
            {
                $response['success'] = false;
                $response['errors'][] = trans('vaahcms-user.username_already_registered');
                return $response;
            }

            $item = self::find($request->id);
        } else
        {
            $validation = self::userValidation($request);
            if(isset($validation['success']) && !$validation['success'])
            {
                return $validation;
            } else if(isset($validation['status'])
                && $validation['status'] == 'registration-exist')
            {
                $item = $validation['data'];
            } else
            {
                $item = new User();
                $item->password = generate_password();
                $item->is_active = 1;
                $item->status = 'active';
                $item->activated_at = date('Y-m-d H:i:s');
                $item->uuid = Str::uuid();
            }
        }

        $item->fill($inputs);
        if($request->has('password'))
        {
            $item->password = $request->password;
        }

        $item->save();

        if(!$request->has('id'))
        {
            Role::syncRolesWithUsers();
        }


        $response['success'] = true;
        $response['messages'][] = 'Saved';
        $response['data'] = $item;

        return $response;


    }
    //-------------------------------------------------
    public static function bulkStatusChange($request)
    {

        if(!$request->has('inputs'))
        {
            $response['success'] = false;
            $response['errors'][] = 'Select IDs';
            return $response;
        }

        if(!$request->has('data'))
        {
            $response['success'] = false;
            $response['errors'][] = 'Select Status';
            return $response;
        }

        foreach($request->inputs as $id)
        {
            $reg = self::where('id',$id)->withTrashed()->first();

            if($reg->deleted_at){
                continue ;
            }

            $is_restricted = self::restrictedActions($request->action, $reg->id);

            if($is_restricted && $reg->is_active == 1)
            {
                continue;
            }

            if($request['data']){
                $reg->is_active = $request['data']['status'];
                if( $request['data']['status'] == 1){
                    $reg->status = 'active';
                }else{
                    $reg->status = 'inactive';
                }
            }else{
                if($reg->is_active == 1){
                    $reg->is_active = 0;
                    $reg->status = 'inactive';
                }else{
                    $reg->is_active = 1;
                    $reg->status = 'active';
                }
            }

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
            $response['errors'][] = 'Select IDs';
            return $response;
        }

        foreach($request->inputs as $id)
        {
            $item = self::find($id);
            if($item)
            {


                $is_restricted = self::restrictedActions($request->action, $item->id);

                if($is_restricted)
                {
                    continue;
                }

                $item->is_active = 0;
                $item->status = 'inactive';
                $item->save();

                $item->delete();
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
            $response['errors'][] = 'Select IDs';
            return $response;
        }

        if(!$request->has('data'))
        {
            $response['success'] = false;
            $response['errors'][] = 'Select Status';
            return $response;
        }


        foreach($request->inputs as $id)
        {

            $item = self::withTrashed()->where('id', $id)->first();

            if(isset($item) && isset($item->deleted_at))
            {
                $item->restore();
            }
        }

        $response['success'] = true;
        $response['data'] = [];
        $response['messages'][] = trans('vaahcms-general.action_successful');

        return $response;


    }
    //-------------------------------------------------

    public static function bulkChangeRoleStatus($request)
    {

        $inputs = $request->all();

        $role = Role::find($inputs['inputs']['role_id']);

        if($inputs['inputs']['id'] == 1 && $role->slug == 'super-administrator'
            && $inputs['data']['is_active'] == 0)
        {
            $response['success'] = false;
            $response['errors'][] = trans('vaahcms-user.first_user_super_administrator');
            return $response;
        }

        $item = self::find($inputs['inputs']['id']);


        $data = [
            'is_active' => $inputs['data']['is_active'],
            //'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now()
        ];


        if($inputs['inputs']['role_id']){
            $pivot = $item->roles->find($inputs['inputs']['role_id'])->pivot;

            if($pivot->is_active === null && !$pivot->created_by){
                //$data['created_by'] = Auth::user()->id;
                $data['created_at'] = Carbon::now();
            }

            $item->roles()->updateExistingPivot(
                $inputs['inputs']['role_id'],
                $data
            );
        }else{
            $item->roles()
                ->newPivotStatement()
                ->where('vh_user_id', '=', $item->id)
                ->update($data);
        }

        Role::recountRelations();

        $response['success'] = true;
        $response['data'] = [];

        return $response;


    }

    //-------------------------------------------------

    public static function bulkDelete($request)
    {

        if(!$request->has('inputs'))
        {
            $response['success'] = false;
            $response['errors'][] = 'Select IDs';
            return $response;
        }

        if(!$request->has('data'))
        {
            $response['success'] = false;
            $response['errors'][] = 'Select Status';
            return $response;
        }

        foreach($request->inputs as $id)
        {
            $item = self::where('id', $id)->withTrashed()->first();
            if($item)
            {

                $is_restricted = self::restrictedActions($request->action, $item->id);

                if($is_restricted)
                {
                    continue;
                }

                $item->roles()->detach();

                $item->forceDelete();

            }
        }

        $response['success'] = true;
        $response['data'] = [];
        $response['messages'][] = trans('vaahcms-general.action_successful');

        return $response;


    }
    //-------------------------------------------------

    //-------------------------------------------------
    public static function validation($inputs){

        $rules = array(

            'email' => 'required|email|max:150',
            'first_name' => 'required|max:150',
            'status' => 'required',
            'is_active' => 'required',
            'foreign_user_id' => 'nullable|numeric|min:1',

        );

        if(isset($inputs['username']))
        {
            $rules['username'] = 'required';
        }

        $validator = \Validator::make($inputs,$rules);

        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }

    }
    //-------------------------------------------------
    public static function storeProfile($request)
    {
        $rules = array(
            'first_name' => 'required|max:150',
            'last_name' => 'required|max:150',
            'email' => 'required|email|max:150',
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
            return response()->json($response);
        }

        if(!\Auth::check())
        {
            $response['success'] = false;
            $response['errors'][] = trans('vaahcms-user.logged_in_to_update_profile');
            return $response;
        }


        $inputs = $request->all();

        $user = self::find(\Auth::user()->id);


        if(
            $request->has('username') && !empty($request->username)
            && $request->username != $user->username
        )
        {
            $user_exist = self::where('username', $request->username)
                ->first();
            if($user_exist)
            {
                $response['success'] = false;
                $response['errors'][] = trans('vaahcms-user.username_already_taken');
                return $response;
            }
        }

        if($user->email != $inputs['email'] && !empty($inputs['email']))
        {

            $email_exist = self::where('email', $inputs['email'])
                ->first();

            if($email_exist)
            {
                $response['success'] = false;
                $response['errors'][] = trans('vaahcms-user.email_associate_with_other_user');
                return $response;
            }

        }

        if(isset($inputs['password']))
        {
            unset($inputs['password']);
        }

        $user->fill($inputs);
        $user->save();


        $response['success'] = true;
        $response['data'][] = '';
        $response['messages'][] = trans('vaahcms-general.action_successful');
        return $response;


    }
    //-------------------------------------------------
    public static function storePassword($request)
    {
        $rules = array(
            'current_password' => 'required|max:25',
            'new_password' => 'required|max:25',
            'confirm_password' => 'required|max:25',
        );

        $validator = \Validator::make($request->all(),$rules);

        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }

        if($request->new_password != $request->confirm_password)
        {
            $response['success'] = false;
            $response['errors'][] = trans('vaahcms-user.confirm_password_not_match');
            return $response;
        }


        try{

            $check = \Hash::check($request->current_password, auth()->user()->password);

            if(!$check)
            {
                $response['success'] = false;
                $response['errors'][] = trans('vaahcms-user.current_password_incorrect');
                return $response;
            }

            $user = self::find(\Auth::user()->id);
            $user->password = $request->new_password;
            $user->save();

            $response['success'] = true;
            $response['data'][] = '';
            $response['messages'][] = trans('vaahcms-general.action_successful');

            return $response;


        }catch(\Exception $e)
        {
            $response['success'] = false;
            $response['errors'][] = $e->getMessage();

        }

        return $response;
    }
    //-------------------------------------------------
    public static function storeAvatar($request,$user_id=null)
    {
        $rules = array(
            'url' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }

        $data = [];

        if(!$user_id)
        {
            $user_id = \Auth::user()->id;
        }

        $user = self::find($user_id);

        $user->avatar_url = $request->url;
        $user->save();

        $response['success'] = true;
        $response['messages'][] = 'Avatar updated.';
        $response['data']['avatar'] = $user->avatar;
        $response['data']['avatar_url'] = $user->avatar_url;

        return $response;

    }
    //-------------------------------------------------
    public static function removeAvatar($user_id=null)
    {

        $data = [];

        if(!$user_id)
        {
            $user_id = \Auth::user()->id;
        }

        $user = self::find($user_id);
        $user->avatar_url = null;
        $user->save();

        $response['success'] = true;
        $response['messages'][] = 'Avatar removed.';
        $response['data']['avatar'] = $user->avatar;
        $response['data']['avatar_url'] = $user->avatar_url;

        return $response;

    }
    //-------------------------------------------------
    public static function getPivotData($pivot)
    {

        $data = array();

        if($pivot->created_by && self::find($pivot->created_by)){
            $data['Created by'] = self::find($pivot->created_by)->name;
        }

        if($pivot->updated_by && self::find($pivot->updated_by)){
            $data['Updated by'] = self::find($pivot->updated_by)->name;
        }

        if($pivot->created_at){
            $data['Created at'] = date('d-m-Y H:i:s', strtotime($pivot->created_at));
        }

        if($pivot->updated_at){
            $data['Updated at'] = date('d-m-Y H:i:s', strtotime($pivot->updated_at));
        }

        return $data;

    }
    //-------------------------------------------------
    public static function getUserSettings($return_hidden_column_name = false,
                                           $return_registration_columns = false)
    {

        $settings = Setting::where('category','user_setting')
            ->where('label','field');

        $settings = $settings->select('id','key','type','value','meta')->get();

        $list = array();

        foreach ($settings as $key => $setting){
            if(!$return_hidden_column_name){
                $list[$setting->key] = $setting->value;
            }elseif(isset($setting->value->is_hidden)
                && $setting->value->is_hidden){
                if(!$return_registration_columns){
                    $list[$key] = $setting->key;
                }elseif(isset($setting->value->to_registration)
                    && $setting->value->to_registration){
                    $list[$key] = $setting->key;
                }
            }

        }

        return $list;

    }
    //-------------------------------------------------
    public function verifySecurityAuthentication()
    {

        try{

            $this->security_code = null;
            $this->security_code_expired_at = null;
            $this->save();

            $has_security = true;

            $response['success'] = false;
            $response['data'] = null;

            if(!config('settings.global.mfa_status')
                || config('settings.global.mfa_status') === 'disable'
                || !is_array(config('settings.global.mfa_methods'))
                || (is_array(config('settings.global.mfa_methods'))
                    && count(config('settings.global.mfa_methods')) == 0)){
                $has_security = false;
            }

            if(config('settings.global.mfa_status') == 'user-will-have-option'
                && (!is_array($this->mfa_methods)
                    || (is_array($this->mfa_methods) && count($this->mfa_methods) == 0))){

                $has_security = false;
            }

            if(!$has_security){
                return $response;
            }

            $this->security_code = rand(100000, 999999);
            $this->security_code_expired_at = now()->addMinutes(10);
            $this->save();

            $vaah_mail_response = VaahMail::dispatch(new SecurityOtpMail($this->toArray()),[$this->email]);


            if(isset($vaah_mail_response['success']) && !$vaah_mail_response['success']){
                return $vaah_mail_response;
            }

            $response['success'] = true;

        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return $response;

    }

    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
}
