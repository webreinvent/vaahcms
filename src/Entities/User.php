<?php namespace WebReinvent\VaahCms\Entities;

use Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Password;
use WebReinvent\VaahCms\Traits\CrudWithUidObservantTrait;

class User extends Authenticatable
{

    use Notifiable;
    use SoftDeletes;
    use CrudWithUidObservantTrait;

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
        "uid","email","username","display_name","title","first_name","middle_name","last_name",
        "gender","country_calling_code","phone","timezone","alternate_email","avatar_url","birth",
        "country","country_code","last_login_at","last_login_ip","remember_token","api_token","api_token_used_at",
        "api_token_used_ip","is_active","activated_at","status","affiliate_code","affiliate_code_used_at","reset_password_code",
        "reset_password_code_sent_at","reset_password_code_used_at","meta","created_ip","created_by",
        "updated_by","deleted_by"
    ];
    //-------------------------------------------------
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
        'api_token_used_at',
        'api_token_used_ip',
        'reset_password_code',
    ];

    //-------------------------------------------------

    //-------------------------------------------------
    protected $appends  = [
        'thumbnail', 'name'
    ];

    //-------------------------------------------------
    public function getThumbnailAttribute() {

        if($this->avatar_url)
        {
            return $this->avatar_url;
        }

        $grav_url = vh_get_avatar_by_email($this->email);

        return $grav_url;
    }
    //-------------------------------------------------

    //-------------------------------------------------
    public function getNameAttribute() {

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
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucfirst(trim($value));
    }
    //-------------------------------------------------
    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucfirst(trim($value));
    }
    //-------------------------------------------------
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = trim($value);
    }
    //-------------------------------------------------

    //-------------------------------------------------
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    //-------------------------------------------------
    public function scopeInactive($query)
    {
        return $query->where('is_active', 0);
    }

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
    public function scopeLastLoginBetween($query, $from, $to)
    {
        return $query->whereBetween('last_login_at', array($from, $to));
    }

    //-------------------------------------------------
    public function scopeNeverLoggedIn($query)
    {
        return $query->whereNull('last_login_at');
    }

    //-------------------------------------------------
    public function scopeDoesNotHaveRole($query, $role_id)
    {
        return $query->whereDoesntHave('roles', function ($r) use ($role_id)
        {
            $r->where('vh_role_id', $role_id);
        });
    }
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
    public function getFormElement($column, $value=null)
    {

        $result['name'] = $column;
        $result['value'] = $value;
        $result['type'] = 'text';
        $result['editable'] = true;
        $result['tr_class'] = "";
        $result['disabled'] = false;
        $result['label'] = slug_to_str($column);
        /*$result['column_type'] = $this->getConnection()->getSchemaBuilder()
            ->getColumnType($this->getTable(), $column);*/


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
            case 'updated_by':
            case 'deleted_by':
                $result['type'] = 'select_with_ids';
                $result['editable'] = false;
                $result['inputs'] = User::getUsersForAssets();
                break;
            //------------------------------------------------
            case 'password':
                $result['type'] = 'hidden';
                $result['editable'] = false;
                break;
            //------------------------------------------------
            case 'meta':
            case 'last_login_at':
            case 'last_login_ip':
            case 'remember_token':
            case 'api_token':
            case 'api_token_used_at':
            case 'api_token_used_ip':
            case 'activated_at':
            case 'affiliate_code_used_at':
            case 'reset_password_code_sent_at':
            case 'reset_password_code_used_at':
            case 'created_ip':
            case 'created_at':
            case 'deleted_at':
            case 'updated_at':
                $result['editable'] = false;
                break;
            //------------------------------------------------

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
                $result['inputs'] = vh_user_statuses();
                break;
            //------------------------------------------------
            case 'country':
                $result['type'] = 'select';
                $result['inputs'] = vh_get_country_list_with_slugs();
                break;
            //------------------------------------------------
            //------------------------------------------------
            case 'is_active':
                $result['type'] = 'select';
                $result['inputs'] = vh_is_active_options();
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
    //-------------------------------------------------
    //-------------------------------------------------
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
    public static function countAdmins()
    {
        $count = User::whereHas('roles', function ($query) {
            $query->slug('admin');
        })->count();
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
        $list = User::getByRoles($array_role_slugs)->pluck('id')->toArray();
        return $list;
    }
    //-------------------------------------------------
    public static function getByRolesOnlyEmails($array_role_slugs)
    {
        $list = User::getByRoles($array_role_slugs)->pluck('email')->toArray();
        return $list;
    }
    //-------------------------------------------------
    public function permissions()
    {
        $roles = $this->roles()->get();
        $permissions_list = array();
        foreach ($roles as $role) {
            $permissions = $role->permissions()->get();
            foreach ($permissions as $permission) {
                $permissions_list[$permission->id] = $permission->toArray();
            }
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
    public static function store($request)
    {
        $rules = array(
            'email' => 'required|email',
            'first_name' => 'required',
        );

        if($request->has('phone'))
        {
            $rules['phone'] = 'integer';
        }


        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }

        $data = [];

        $inputs = $request->all();


        if($request->has('birth'))
        {
            $inputs['birth'] = Carbon::parse($request->birth)->format('Y-m-d');
        }

        if($request->has('id'))
        {
            $item = User::find($request->id);
        } else
        {
            $validation = static::userValidation($request);
            if(isset($validation['status']) && $validation['status'] == 'failed')
            {
                return $validation;
            } else if(isset($validation['status']) && $validation['status'] == 'registration-exist')
            {
                $item = $validation['data'];
            } else
            {
                $item = new User();
                $item->password = generate_password();
                $item->is_active = 1;
                $item->status = 'active';
                $item->activated_at = date('Y-m-d H:i:s');
                $item->uid = uniqid();
            }
        }

        $item->fill($inputs);
        if($request->has('password'))
        {
            $item->password = Hash::make($request->password);
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
            } else
            {
                $result[$i] = $this->getFormElement($column, "");
                $i++;
            }

        }


        return $result;
    }
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
            $response['errors'][] = 'The registration status is "registered", hence user id is required';
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
            $reg = User::find($id);
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
            $item = User::find($id);
            if($item)
            {
                $item->is_active = 0;
                $item->status = 'inactive';
                $item->save();

                $item->delete();
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
            $item = User::withTrashed()->where('id', $id)->first();
            if(isset($item) && isset($item->deleted_at))
            {
                $item->restore();
            }
        }

        $response['status'] = 'success';
        $response['messages'][] = 'Action was successful';

        return $response;


    }
    //-------------------------------------------------
    public static function onlyOneAdminValidation($user_id)
    {
        $user = User::where('id', $user_id)->withTrashed()->first();

        if(isset($user->deleted_at))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Account is deleted, hence you can not perform this action.';
            return $response;

        }

        $count_admin = User::countAdmins();

        if($user->isAdmin() && $count_admin < 2)
        {
            $response['status'] = 'failed';
            $response['errors'][] = "You have only one admin account which can't be deactivated.";
            return $response;
        }

        $response['status'] = 'success';

        return $response;

    }
    //-------------------------------------------------

    public static function login($request)
    {

        //check if already logged in
        if (Auth::check())
        {
            Auth::logout();
        }

        $rules = array(
            'email' => 'required|email',
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
            'password' => 'required',
        );
        $validator = \Validator::make($inputs, $rules);

        if ($validator->fails())
        {
            $errors = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }

        $remember = false;
        if ($request->has("remember") || $request->get("remember") == "on") {
            $remember = true;
        }

        $user = static::where('email', $inputs['email'])->first();


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
    public static function resetPasswordEmail($request)
    {



    }
    //-------------------------------------------------
    public function hasRole($role_slug)
    {
        foreach ($this->roles()->get() as $role) {
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
        return $this->hasRole('admin');
    }

    //-------------------------------------------------
    public function hasPermission($permission_slug)
    {


        if ($this->isAdmin()) {

            $response['status'] = 'success';
            if(env('APP_DEBUG'))
            {
                $response['data']['permission'] = 'Permission slug: '.$permission_slug;
                $response['hint'][] = 'Admin has all permission by default.';
            }
            return $response;
        }

        //check if permission exist or not
        $permission = Permission::where('slug', $permission_slug)
            ->first();

        if (!$permission)
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'No Permission exist with slug: '.$permission_slug;

            if(env('APP_DEBUG'))
            {
                $response['hint'][] = 'Check the migrations & seeds are properly run.';
            }

            return $response;
        }

        if ($permission->is_active != 1) {
            $response['status'] = 'failed';
            $response['errors'][] = $permission_slug.' is inactive';
            if(env('APP_DEBUG'))
            {
                $response['hint'][] = 'Enable the permission status to active from backend/admin control panel.';
            }
            return $response;
        }

        foreach ($this->permissions() as $permission)
        {
            if ($permission['slug'] == $permission_slug
                && $permission['is_active'] == 1
                && $permission['pivot']['is_active'] == 1
            )
            {
                $response['status'] = 'success';
                if(env('APP_DEBUG'))
                {
                    $response['hint'][] = 'Permission slug: '.$permission_slug.' is active for '.\Auth::user()->email;
                }
                return $response;
                break;
            }
        }

        $response['status'] = 'failed';
        $response['errors'][] = trans("vaahcms::messages.permission_denied");
        if(env('APP_DEBUG'))
        {
            $response['hint'][] = 'Permission slug: '.$permission_slug.' is not active for '.\Auth::user()->email;
        }
        return $response;

    }

    //-------------------------------------------------
    public function getPermissionsSlugs()
    {
        $roles = $this->roles()->get();
        $permissions_list = array();
        foreach ($roles as $role) {
            $permissions = $role->permissions()->get();
            foreach ($permissions as $permission) {
                $permissions_list[$permission->id] = $permission->slug;
            }
        }
        return $permissions_list;
    }
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
        $admins = $users->listByRole('admin');

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
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
}
