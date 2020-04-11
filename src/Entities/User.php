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
use Illuminate\Support\Str;
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
        "uuid","email","username","display_name","title","first_name","middle_name","last_name",
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
    public function permissions($slugs_only=false)
    {
        $roles = $this->roles()->wherePivot('is_active', 1)->get();
        $permissions_list = array();
        foreach ($roles as $role) {
            $permissions = $role->permissions()->wherePivot('is_active', 1)->get();
            foreach ($permissions as $permission) {
                $permissions_list[$permission->id] = $permission->toArray();
            }
        }

        if($slugs_only)
        {
            $permissions_list = collect($permissions_list)->pluck('slug')->toArray();
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

    public static function create($request)
    {

        if(!\Auth::user()->hasPermission('can-create-users',true))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

        $inputs = $request->new_item;

        $validate = static::validation($inputs);

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
        $user = static::where('email',$inputs['email'])->first();

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
        return $response;

    }

    //-------------------------------------------------
    public static function store($request)
    {

        if(!\Auth::user()->hasPermission('can-update-users',true))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

        $inputs = $request->all();

        $validate = static::validation($inputs);

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
                $item->uuid = Str::uuid();
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

        if(!\Auth::user()->hasPermission('can-manage-users',true) &&
            !\Auth::user()->hasPermission('can-update-users',true))
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

            $is_restricted = static::restrictedActions($request->action, $reg->id);

            if($is_restricted)
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

        if(!\Auth::user()->hasPermission('can-update-users',true))
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

        if(!\Auth::user()->hasPermission('can-update-registrations',true))
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
    public static function isLastAdmin()
    {
        $count_admin = User::countAdmins();
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
        if($user_id == \Auth::user()->id)
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


        //restricted action if this user is last admin
        $result = false;
        $user = static::find($user_id);
        $is_last_admin = static::isLastAdmin();

        if($user->hasRole('admin') && $is_last_admin)
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
        return $this->hasRole('admin');
    }

    //-------------------------------------------------
    public function hasPermission($permission_slug, $boolean=false)
    {

        if ($this->isAdmin()) {

            if($boolean)
            {
                return true;
            } else{
                $response['status'] = 'success';
                if(env('APP_DEBUG'))
                {
                    $response['data']['permission'] = 'Permission slug: '.$permission_slug;
                    $response['hint'][] = 'Admin has all permission by default.';
                }
                return $response;
            }

        }

        //check if permission exist or not
        $permission = Permission::where('slug', $permission_slug)
            ->first();

        if (!$permission)
        {
            if($boolean)
            {
                return false;
            } else {
                $response['status'] = 'failed';
                $response['errors'][] = 'No Permission exist with slug: ' . $permission_slug;

                if (env('APP_DEBUG')) {
                    $response['hint'][] = 'Check the migrations & seeds are properly run.';
                }

                return $response;
            }
        }

        if ($permission->is_active != 1) {
            if($boolean)
            {
                return false;
            } else{
                $response['status'] = 'failed';
                $response['errors'][] = $permission_slug.' is inactive';
                if(env('APP_DEBUG'))
                {
                    $response['hint'][] = 'Enable the permission status to active from backend/admin control panel.';
                }
                return $response;
            }

        }

        foreach ($this->permissions() as $permission)
        {


            if ($permission['slug'] == $permission_slug
                && $permission['is_active'] == 1
                && $permission['pivot']['is_active'] == 1
            )
            {
                if($boolean)
                {
                    return true;
                } else{
                    $response['status'] = 'success';
                    $response['data'] = [];
                    if(env('APP_DEBUG'))
                    {
                        $response['hint'][] = 'Permission slug: '.$permission_slug.' is active for '.\Auth::user()->email;
                    }
                    return $response;

                }
                break;
            }
        }

        if($boolean)
        {
            return false;
        } else{
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");
            if(env('APP_DEBUG'))
            {
                $response['hint'][] = 'Permission slug: '.$permission_slug.' is not active for '.\Auth::user()->email;
            }
            return $response;
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
    public static function getList($request)
    {

        if(!\Auth::user()->hasPermission('has-access-of-users-section',true))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

        if($request->has('recount') && $request->get('recount') == true)
        {
            Role::syncRolesWithUsers();
        }

        $list = static::orderBy('created_at', 'DESC');

        if($request->has('trashed') && $request->trashed == 'true')
        {
            $list->withTrashed();
        }

        if($request['status'] && $request['status'] == '1')
        {

            $list->where('is_active',$request['status']);
        }elseif($request['status'] == '10'){

            $list->whereNull('is_active')->orWhere('is_active',0);
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

        $list->withCount(['activeRoles']);

        $list = $list->paginate(config('vaahcms.per_page'));
        $countRole = Role::all()->count();

        $response['status'] = 'success';
        $response['data']['list'] = $list;
        $response['data']['totalRole'] = $countRole;

        return $response;

    }

    //-------------------------------------------------

    public static function bulkChangeRoleStatus($request)
    {

        if(!\Auth::user()->hasPermission('can-manage-users',true) &&
            !\Auth::user()->hasPermission('can-update-users',true))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

        $inputs = $request->all();


        if($inputs['inputs']['id'] == 1 && $inputs['inputs']['user_id'] == 1)
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'First user will always be an admin';
            return response()->json($response);
        }

        $item = User::find($inputs['inputs']['id']);

        if($inputs['inputs']['role_id']){
            $item->roles()->updateExistingPivot($inputs['inputs']['role_id'], array('is_active' => $inputs['data']['is_active']));
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

        if(!\Auth::user()->hasPermission('can-update-registrations',true) ||
            !\Auth::user()->hasPermission('can-delete-registrations',true))
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
            $item = static::where('id', $id)->withTrashed()->first();
            if($item)
            {

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

    public static function getDetail($id)
    {

        if(!\Auth::user()->hasPermission('can-manage-users',true) &&
            !\Auth::user()->hasPermission('can-update-users',true) &&
            !\Auth::user()->hasPermission('can-create-users',true) &&
            !\Auth::user()->hasPermission('can-read-users',true))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

        $item = static::where('id', $id)->with(['createdByUser', 'updatedByUser', 'deletedByUser'])->withTrashed()->first();

        $response['status'] = 'success';
        $response['data'] = $item;

        return $response;

    }

    //-------------------------------------------------

    public static function getItemRoles($request,$id)
    {

        if(!\Auth::user()->hasPermission('can-manage-users',true) &&
            !\Auth::user()->hasPermission('can-update-users',true) &&
            !\Auth::user()->hasPermission('can-read-users',true))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

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

    //-------------------------------------------------
    public static function validation($request){

        $rules = array(

            'email' => 'required|email',
            'first_name' => 'required',
            'status' => 'required',
            'is_active' => 'required',

        );


        $validator = \Validator::make($request,$rules);

        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }

    }
    //-------------------------------------------------
    //-------------------------------------------------
}
