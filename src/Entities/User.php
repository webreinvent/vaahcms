<?php namespace WebReinvent\VaahCms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Password;

class User extends Authenticatable
{

    use Notifiable;

    use SoftDeletes;
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
        'thumbnail',
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
        );
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

    //-------------------------------------------------
    public static function login($request)
    {

        //check if already logged in
        if (Auth::check())
        {
            Auth::logout();
        }

        $rules = array(
            'email' => 'required',
        );
        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            $errors = $validator->errors();
            $response['status'] = 'failed';
            $response['errors'] = $errors;
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
            $errors = $validator->errors();
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }

        $remember = false;
        if ($request->has("remember") || $request->get("remember") == "on") {
            $remember = true;
        }


        if (Auth::attempt(['email' => $inputs['email'],
            'password' => trim($request->get('password'))
        ], $remember))
        {
            $user = Auth::user();

            //check user is active
            if($user->is_active == 0)
            {
                $response['status'] = 'failed';
                $response['errors'][] = getConstant('account.disabled');
                return $response;
            }

            $user->last_login_at = \Carbon::now();
            $user->save();


            $response['status'] = 'success';
            $response['data'] = Auth::user();
            $redirect = $request->input('redirect_url', \URL::route('vh.admin.dashboard'));
            $response['redirect_url'] = $redirect;

        } else {
            $response['status'] = 'failed';
            $response['errors'][] = getConstant('credentials.invalid');
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
    public function hasPermission($permission_uid)
    {

        //check if permission exist or not
        $permission = Permission::where('uid', $permission_uid)
            ->first();

        if (!$permission)
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'No Permission exist with UID: '.$permission_uid;
            return response()->json($response);
        }

        if ($this->isAdmin()) {

            return true;
        }

        if ($permission->is_active == 0) {
            return false;
        }

        foreach ($this->permissions() as $permission)
        {
            if ($permission['uid'] == $permission_uid && $permission['is_active'] == 1)
            {
                return true;
            }
        }
        return false;
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
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
}
