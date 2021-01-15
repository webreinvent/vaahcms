<?php namespace WebReinvent\VaahCms\Entities;



use App\Mail\OrderShipped;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Jobs\ProcessMails;
use WebReinvent\VaahCms\Jobs\ProcessNotifications;
use WebReinvent\VaahCms\Libraries\VaahMail;
use WebReinvent\VaahCms\Mail\TestMail;
use WebReinvent\VaahCms\Traits\CrudWithUuidObservantTrait;

class User extends Authenticatable
{

    use Notifiable;
    use SoftDeletes;
    use CrudWithUuidObservantTrait;

    //-------------------------------------------------
    protected $table = 'vh_users';
    //-------------------------------------------------
    protected $dates = [
        "last_login_at", "api_token_used_at",
        "affiliate_code_used_at", "reset_password_code_sent_at",
        "reset_password_code_used_at",
        "birth", "activated_at",
        "created_at","updated_at","deleted_at"
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
        "uuid","email","username","display_name","title",
        "first_name","middle_name","last_name", "password",
        "gender","country_calling_code","phone", "bio",
        "website","timezone",
        "alternate_email","avatar_url","birth",
        "country","country_code","last_login_at","last_login_ip",
        "remember_token", "login_otp", "api_token","api_token_used_at",
        "api_token_used_ip","is_active","activated_at","status",
        "affiliate_code","affiliate_code_used_at","reset_password_code",
        "reset_password_code_sent_at","reset_password_code_used_at",
        "meta","created_ip","created_by",
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

    //-------------------------------------------------
    protected $appends  = [
        'avatar', 'name'
    ];

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
        return json_decode($value);
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
        $this->attributes['password'] = Hash::make($value);
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
    public function setResetPasswordCodeAttribute($value) {
        $this->attributes['reset_password_code'] = Hash::make($value);
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
            'affiliate_code', 'affiliate_code_used_at', 'created_by', 'updated_by',
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
        return $this->belongsToMany('WebReinvent\VaahCms\Entities\Role',
            'vh_user_roles', 'vh_user_id', 'vh_role_id'
        )->withPivot('is_active');
    }

    //-------------------------------------------------
    public function activeRoles()
    {
        return $this->roles()->wherePivot('is_active', 1);
    }
    //-------------------------------------------------
    public static function countAdministrators()
    {
        $count = User::whereHas('roles', function ($query) {
            $query->where('vh_user_roles.is_active', '=', 1)
                ->slug('administrator');
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

        })->with(['roles'])->active()->get();

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

            if($role->slug !='administrator')
            {
                $permissions = $role->permissions()->isActive()
                    ->wherePivot('is_active', 1)->get();
            } else{
                $permissions = $role->permissions()->get();
            }

            foreach ($permissions as $permission) {

                if($role->slug =='administrator')
                {
                    $permissions_list[$permission->id] = $permission->toArray();

                } else{
                    if(!$permission->is_active)
                    {
                        continue;
                    }
                    $permissions_list[$permission->id] = $permission->toArray();
                }
            }
        }

        if($slugs_only)
        {
            $permissions_list = collect($permissions_list)
                ->pluck('slug')->toArray();
        }

        return $permissions_list;
    }

    //-------------------------------------------------

    //-------------------------------------------------
    public static function rulesAdminCreate()
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
            $response['errors'][] = 'The registration status is "registered", hence user
            id is required';
            return $response;
        }

        //check if registration record exist
        $reg_by_email = User::findByEmail($request->email);
        if($reg_by_email)
        {
            $response['status'] = 'registration-exist';
            $response['data'] = $reg_by_email;
            return $response;
        }

        if($request->has('country_calling_code') && $request->has('phone')) {
            $reg_by_phone = User::where('country_calling_code', $request->country_calling_code)
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
    public static function isLastAdmin()
    {
        $count_admin = User::countAdministrators();
        if($count_admin < 2)
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


        //restricted action if this user is last admin
        $result = false;
        $user = self::find($user_id);
        $is_last_admin = self::isLastAdmin();

        if($user->hasRole('administrator') && $is_last_admin)
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
    public static function beforeUserActionValidation($request): array
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
            $response['status'] = 'failed';
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
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }

        $user = self::where('email', $inputs['email'])->first();

        //check user is active
        if(!$user)
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'No user exist';
            return $response;
        }

        //check user is active
        if($user->is_active != 1)
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans('vaahcms::messages.inactive_account');
            return $response;
        }

        return $user;
    }
    //-------------------------------------------------

    public static function login($request)
    {

        $user = self::beforeUserActionValidation($request);

        if(isset($user['status']) && $user['status'] == 'failed')
        {
            return $user;
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

            $response['status'] = 'success';
        } else {
            $response['status'] = 'failed';
            $response['errors'][] = trans('vaahcms::messages.invalid_credentials');
        }

        return $response;
    }
    //-------------------------------------------------
    public static function sendLoginOtp($request): array
    {
        $user = self::beforeUserActionValidation($request);
        if(isset($user['status']) && $user['status'] == 'failed')
        {
            return $user;
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

        if(isset($response['status']) && $response['status'] == 'failed')
        {
            return $response;
        }

        $response['status'] = 'success';
        $response['messages'] = [
            "A one time password (OTP) has been sent to your email."
        ];

        return $response;
    }
    //-------------------------------------------------
    public static function loginViaOtp($request): array
    {

        $user = self::beforeUserActionValidation($request);

        if(isset($user['status']) && $user['status'] == 'failed')
        {
            return $user;
        }

        $rules = array(
            'login_otp' => 'required|digits:6',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }


        /*if(count($request->login_otp) < 6
            || is_null($user->login_otp)
            || empty($user->login_otp)
        )
        {
            $response['status'] = 'failed';
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

            $response['status'] = 'success';
            $response['data'] = [];

        } else {
            $response['status'] = 'failed';
            $response['errors'][] = trans('vaahcms::messages.invalid_credentials');
        }
        return $response;

    }
    //-------------------------------------------------
    public static function sendResetPasswordEmail($request): array
    {

        $user = self::beforeUserActionValidation($request);
        if(isset($user['status']) && $user['status'] == 'failed')
        {
            return $user;
        }

        $reset_password_code = uniqid();

        $user->reset_password_code = $reset_password_code;
        $user->save();

        $notification = Notification::where('slug', 'send-reset-password-email')
            ->first();

        $inputs = [
            'user_id' => $user->id,
            'notification_id' => $notification->id,
            'reset_password_code' => $reset_password_code,
        ];

        $request = new Request($inputs);


        $response = Notification::send($request);

        if(isset($response['status']) && $response['status'] == 'failed')
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

        $user = self::beforeUserActionValidation($request);

        if(isset($user['status']) && $user['status'] == 'failed')
        {
            return $user;
        }

        $rules = array(
            'reset_password_code' => 'required',
            'password' => 'required|confirmed|min:6',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }

        if(!Hash::check($request->reset_password_code, $user->reset_password_code))
        {
            $response['status'] = 'failed';
            $response['errors'][] = "Incorrect reset password code";
            return $response;
        }

        $user->password = $request->password;
        $user->reset_password_code = null;
        $user->save();

        $response['status'] = 'success';
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
    public function isAdmin()
    {
        return $this->hasRole('administrator');
    }

    //-------------------------------------------------
    public function hasPermission($permission_slug, $details=false)
    {

        if ($this->isAdmin()) {

            if($details)
            {
                $response['status'] = 'success';
                if(env('APP_DEBUG'))
                {
                    $response['data']['permission'] = 'Permission slug: '.$permission_slug;
                    $response['hint'][] = 'Admin has all permission by default.';
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
                $response['status'] = 'failed';
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
                $response['status'] = 'failed';
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
                    $response['status'] = 'success';
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
            $response['status'] = 'failed';
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
        $user = User::find($id);
        return $user->thumbnail;
    }
    //-------------------------------------------------
    public static function notifyAdmins($subject, $message)
    {
        $users = new User();
        $admins = $users->listByRole('administrator');

        $notification = new \stdClass();
        $notification->subject = $subject;
        $notification->message = $message;

        Notification::send($admins, new NotifyAdmin($notification));
    }
    //-------------------------------------------------
    public static function getUsersForAssets()
    {

        $list = User::active()
            ->select('id', 'first_name', 'middle_name', 'last_name')
            ->get();

        return $list;

    }
    //-------------------------------------------------

    public static function create($request)
    {

        $inputs = $request->new_item;

        $validate = self::validation($inputs);

        if(isset($validate['status']) && $validate['status'] == 'failed')
        {
            return $validate;
        }

        $rules = array(
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
        $user = self::where('email',$inputs['email'])->first();

        if($user)
        {
            $response['status'] = 'failed';
            $response['errors'][] = "This email is already registered.";
            return $response;
        }

        if(!isset($inputs['username']))
        {
            $inputs['username'] = Str::slug($inputs['email']);
        }

        if(!isset($inputs['status']))
        {
            $inputs['status'] = 'inactive';
        }

        $inputs['created_ip'] = request()->ip();

        $reg = new static();
        $reg->fill($inputs);
        $reg->save();

        Role::syncRolesWithUsers();

        $response['status'] = 'success';
        $response['data']['item'] = $reg;
        $response['messages'][] = 'Saved successfully.';
        return $response;

    }
    //-------------------------------------------------
    public static function getList($request)
    {

        if(isset($request['recount']) && $request['recount'] == true)
        {
            Role::syncRolesWithUsers();
        }

        $list = self::orderBy('created_at', 'DESC');

        if(isset($request['trashed']) && $request['trashed'] == 'true')
        {
            $list->withTrashed();
        }

        if(isset($request['from']) && isset($request['to']))
        {
            $list->betweenDates($request['from'],$request['to']);
        }

        if(isset($request['status'])){
            if($request['status'] == '1')
            {
                $list->where('is_active',$request['status']);
            }elseif($request['status'] == '10'){
                $list->whereNull('is_active')->orWhere('is_active',0);
            }
        }

        if(isset($request['roles']) && is_array($request['roles']) && count($request['roles']) > 0){

            $list->whereHas('roles', function ($query) use ($request){
                $query->where('vh_user_roles.is_active', '=', 1)->whereIn('vh_roles.slug', $request['roles']);
            });

        }elseif(isset($request['roles']) && $request['roles']){
            $list->whereHas('roles', function ($query) use ($request){
                $query->where('vh_user_roles.is_active', '=', 1)->where('vh_roles.slug', $request['roles']);
            });
        }

        if(isset($request['q']))
        {
            $list->where(function ($q) use ($request){
                $q->where('first_name', 'LIKE', '%'.$request['q'].'%')
                    ->orWhere('last_name', 'LIKE', '%'.$request['q'].'%')
                    ->orWhere('middle_name', 'LIKE', '%'.$request['q'].'%')
                    ->orWhere('email', 'LIKE', '%'.$request['q'].'%')
                    ->orWhere('id', '=', $request['q']);
            });
        }



        if(!\Auth::user()->hasPermission('can-see-users-contact-details')){
            $list->exclude(['email','alternate_email', 'phone']);
        }

        $list->withCount(['activeRoles']);

        $list = $list->paginate(config('vaahcms.per_page'));
        $countRole = Role::all()->count();

        $response['status'] = 'success';
        $response['data']['list'] = $list;
        $response['data']['totalRole'] = $countRole;
        $response['fsfsf']['totalRole'] = $request;

        return $response;

    }

    //-------------------------------------------------

    public static function getItem($id)
    {

        $item = self::where('id', $id)->with(['createdByUser',
            'updatedByUser', 'deletedByUser'])
            ->withTrashed();

        if(!\Auth::user()->hasPermission('can-see-users-contact-details')){
            $item->exclude(['email','alternate_email', 'phone']);
        }

        $item = $item->first();

        $response['status'] = 'success';
        $response['data'] = $item;

        return $response;

    }

    //-------------------------------------------------

    public static function getItemRoles($request,$id)
    {

        $item = User::withTrashed()->where('id', $id)->first();

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

        $response['data']['list'] = $list;
        $response['status'] = 'success';

        return $response;

    }

    //-------------------------------------------------
    public static function postStore($request)
    {

        $inputs = $request->all();

        $validate = self::validation($inputs);

        if(isset($validate['status']) && $validate['status'] == 'failed')
        {
            return $validate;
        }

        if(isset($inputs['phone']))
        {
            $rules['phone'] = 'integer';

            $validator = \Validator::make( $request->all(), $rules);
            if ( $validator->fails() ) {

                $errors             = errorsToArray($validator->errors());
                $response['status'] = 'failed';
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
            $item = User::find($request->id);
        } else
        {
            $validation = self::userValidation($request);
            if(isset($validation['status']) && $validation['status'] == 'failed')
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


        $response['status'] = 'success';
        $response['messages'][] = 'Saved';
        $response['data'] = $item;

        return $response;


    }
    //-------------------------------------------------
    public static function bulkStatusChange($request)
    {

        if(!\Auth::user()->hasPermission('can-manage-users') &&
            !\Auth::user()->hasPermission('can-update-users'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

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
            $reg = User::where('id',$id)->withTrashed()->first();

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

        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = 'Action was successful';

        return $response;


    }
    //-------------------------------------------------
    public static function bulkTrash($request)
    {

        if(!\Auth::user()->hasPermission('can-update-users'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

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
            $item = User::find($id);
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

        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = 'Action was successful';

        return $response;


    }
    //-------------------------------------------------
    public static function bulkRestore($request)
    {

        if(!\Auth::user()->hasPermission('can-update-users'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

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

            $item = User::withTrashed()->where('id', $id)->first();

            if(isset($item) && isset($item->deleted_at))
            {
                $item->restore();
            }
        }

        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = 'Action was successful';

        return $response;


    }
    //-------------------------------------------------

    public static function bulkChangeRoleStatus($request)
    {

        if(!\Auth::user()->hasPermission('can-manage-users') &&
            !\Auth::user()->hasPermission('can-update-users'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

        $inputs = $request->all();


        if($inputs['inputs']['id'] == 1 && $inputs['inputs']['role_id'] == 1)
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'First user will always be an administrator';
            return response()->json($response);
        }

        $item = User::find($inputs['inputs']['id']);

        if($inputs['inputs']['role_id']){
            $item->roles()->updateExistingPivot(
                $inputs['inputs']['role_id'],
                array('is_active' => $inputs['data']['is_active'])
            );
        }else{
            $item->roles()
                ->newPivotStatement()
                ->where('vh_user_id', '=', $item->id)
                ->update(array('is_active' => $inputs['data']['is_active']));
        }

        Role::recountRelations();

        $response['status'] = 'success';
        $response['data'] = [];

        return $response;


    }

    //-------------------------------------------------

    public static function bulkDelete($request)
    {

        if(!\Auth::user()->hasPermission('can-update-users') ||
            !\Auth::user()->hasPermission('can-delete-users'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

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

        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = 'Action was successful';

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

        );

        if(isset($inputs['username']))
        {
            $rules['username'] = 'required';
        }

        $validator = \Validator::make($inputs,$rules);

        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
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
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        if(!\Auth::check())
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'You must be logged in to update your profile';
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
                $response['status'] = 'failed';
                $response['errors'][] = 'Username already taken';
                return $response;
            }
        }

        if($user->email != $inputs['email'] && !empty($inputs['email']))
        {

            $email_exist = self::where('email', $inputs['email'])
                ->first();

            if($email_exist)
            {
                $response['status'] = 'failed';
                $response['errors'][] = 'Email is associated with other user.';
                return $response;
            }

        }

        if(isset($inputs['password']))
        {
            unset($inputs['password']);
        }

        $user->fill($inputs);
        $user->save();


        $response['status'] = 'success';
        $response['data'][] = '';
        $response['messages'][] = 'Action was successful';
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
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }

        if($request->new_password != $request->confirm_password)
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Confirm password does not match';
            return $response;
        }


        try{

            $check = \Hash::check($request->current_password, auth()->user()->password);

            if(!$check)
            {
                $response['status'] = 'failed';
                $response['errors'][] = 'Current password is incorrect';
                return $response;
            }

            $user = self::find(\Auth::user()->id);
            $user->password = $request->new_password;
            $user->save();

            $response['status'] = 'success';
            $response['data'][] = '';
            $response['messages'][] = 'Action was successful';

            return $response;


        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
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
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }

        $data = [];

        if(!$user_id)
        {
            $user_id = \Auth::user()->id;
        }

        $user = User::find($user_id);

        $user->avatar_url = $request->url;
        $user->save();

        $response['status'] = 'success';
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

        $user = User::find($user_id);
        $user->avatar_url = null;
        $user->save();

        $response['status'] = 'success';
        $response['messages'][] = 'Avatar removed.';
        $response['data']['avatar'] = $user->avatar;
        $response['data']['avatar_url'] = $user->avatar_url;

        return $response;

    }
    //-------------------------------------------------
}
