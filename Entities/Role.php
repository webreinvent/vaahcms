<?php namespace WebReinvent\VaahCms\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Traits\CrudWithUuidObservantTrait;

class Role extends Model {

    use SoftDeletes;
    use CrudWithUuidObservantTrait;

    //-------------------------------------------------
    protected $table = 'vh_roles';
    //-------------------------------------------------
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'details',
        'count_users',
        'count_permissions',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    //-------------------------------------------------
    protected $appends  = [
    ];

    //-------------------------------------------------

    protected $casts = [
        "created_at" => 'date:Y-m-d H:i:s',
        "updated_at" => 'date:Y-m-d H:i:s',
        "deleted_at" => 'date:Y-m-d H:i:s'
    ];
    //-------------------------------------------------
    public function scopeSlug( $query, $slug ) {
        return $query->where( 'slug', $slug );
    }
    //-------------------------------------------------
    public function scopeIsActive($query)
    {
        $query->where('vh_roles.is_active', 1);
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

        $query->whereBetween('updated_at',[$from,$to]);
    }

    //-------------------------------------------------

    //-------------------------------------------------
    //-------------------------------------------------
    public function permissions() {
        return $this->belongsToMany( Permission::class,
            'vh_role_permissions', 'vh_role_id', 'vh_permission_id'
        )->withPivot('is_active',
            'created_by',
            'created_at',
            'updated_by',
            'updated_at');
    }
    //-------------------------------------------------
    public function users() {
        return $this->belongsToMany( User::class,
            'vh_user_roles', 'vh_role_id', 'vh_user_id'
        )->withPivot('is_active',
            'created_by',
            'created_at',
            'updated_by',
            'updated_at');
    }
    //-------------------------------------------------
    public static function countUsers($id)
    {

        $role = Role::withTrashed()->where('id', $id)->first();

        if(!$role)
        {
            return 0;
        }

        return $role->users()->wherePivot('is_active', 1)->count();
    }
    //-------------------------------------------------
    public static function countPermissions($id)
    {
        $role = Role::withTrashed()->where('id', $id)->first();
        if(!$role)
        {
            return 0;
        }
        return $role->permissions()
            ->wherePivot('is_active', 1)
            ->count();
    }
    //-------------------------------------------------
    //-------------------------------------------------
    public static function recountRelations()
    {
        $list = Role::withTrashed()->select('id')->get();

        if($list)
        {
            foreach ($list as $item)
            {
                $item->count_users = static::countUsers($item->id);
                $item->count_permissions = static::countPermissions($item->id);
                $item->save();
            }
        }

    }
    //-------------------------------------------------
    public static function syncRolesWithUsers()
    {
        $all_users = User::select('id')->get()->pluck('id')->toArray();
        $all_roles = Role::select('id')->get();

        if(!$all_roles)
        {
            return false;
        }

        foreach ($all_roles as $role)
        {
            $role->users()->syncWithoutDetaching($all_users);
        }


        //enable all roles for admin users
        $admin_role = Role::slug('administrator')->first();
        $admin_users = $admin_role->users()->wherePivot('is_active', 1)
            ->get()
            ->pluck('id')
            ->toArray();
        $pivotData = array_fill(0, count($admin_users), ['is_active' => 1]);
        $syncData  = array_combine($admin_users, $pivotData);
        $admin_role->users()->syncWithoutDetaching($syncData);


        return true;

    }
    //-------------------------------------------------
    public static function create($request)
    {

        if(!\Auth::user()->hasPermission('can-create-roles'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

        $inputs = $request->new_item;

        $validation = static::validation($inputs);
        if(isset($validation['status']) && $validation['status'] == 'failed')
        {
            return $validation;
        }

        // check if name exist
        $user = static::where('name',$inputs['name'])->first();

        if($user)
        {
            $response['status'] = 'failed';
            $response['errors'][] = "This name is already exist.";
            return $response;
        }


        // check if slug exist
        $user = static::where('slug',$inputs['slug'])->first();

        if($user)
        {
            $response['status'] = 'failed';
            $response['errors'][] = "This slug is already exist.";
            return $response;
        }

        $role = new static();
        $role->fill($inputs);
        $role->slug = Str::slug($inputs['slug']);
        $role->save();

        Permission::syncPermissionsWithRoles();
        Role::syncRolesWithUsers();
        Role::recountRelations();

        $response['status'] = 'success';
        $response['data']['item'] = $role;
        $response['messages'][] = 'Saved successfully.';
        return $response;

    }
    //-------------------------------------------------
    public static function getList($request)
    {

        if(isset($request->recount) && $request->recount == true)
        {
            Permission::syncPermissionsWithRoles();
            Role::syncRolesWithUsers();
            Role::recountRelations();
        }

        $list = static::orderBy('id', 'desc');



        if($request['trashed'] == 'true')
        {

            $list->withTrashed();
        }

        if(isset($request->from) && isset($request->to))
        {
            $list->betweenDates($request['from'],$request['to']);
        }

        if($request['filter'] && $request['filter'] == '1')
        {

            $list->where('is_active',$request['filter']);
        }elseif($request['filter'] == '10'){

            $list->whereNull('is_active')->orWhere('is_active',0);
        }

        if(isset($request->q))
        {

            $list->where(function ($q) use ($request){
                $q->where('name', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('slug', 'LIKE', '%'.$request->q.'%');
            });
        }


        $data['list'] = $list->paginate(config('vaahcms.per_page'));

        $countPermission = Permission::all()->count();

        $countUser = User::all()->count();


        $response['status'] = 'success';
        $response['data'] = $data;
        $response['data']['totalPermission'] = $countPermission;
        $response['data']['totalUser'] = $countUser;

        return $response;


    }
    //-------------------------------------------------
    public static function getItem($id)
    {

        $item = Role::where('id', $id)->with(['createdByUser', 'updatedByUser', 'deletedByUser'])->withTrashed()->first();

        $response['status'] = 'success';
        $response['data'] = $item;

        return $response;

    }
    //-------------------------------------------------
    public static function getRolePermission($request,$id)
    {

        $item = Role::withTrashed()->where('id', $id)->first();
        $response['data']['item'] = $item;

        if($request->has("q"))
        {
            $list = $item->permissions()->where(function ($q) use ($request){
                $q->where('name', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('slug', 'LIKE', '%'.$request->q.'%');
            });
        } else
        {
            $list = $item->permissions();
        }

        if($request['filter']['module']){
            $list->where('module',$request['filter']['module']);
        }

        if($request['filter']['section']){
            $list->where('section',$request['filter']['section']);
        }

        $list->orderBy('pivot_is_active', 'desc');


        $list = $list->paginate(config('vaahcms.per_page'));

        foreach ($list as $permission){

            $data = self::getPivotData($permission->pivot);

            $permission['json'] = $data;
            $permission['json_length'] = count($data);
        }


        $response['data']['list'] = $list;
        $response['status'] = 'success';

        return $response;


    }
    //-------------------------------------------------
    public static function getRoleUser($request,$id)
    {

        $item = Role::withTrashed()->where('id', $id)->first();
        $response['data']['item'] = $item;

        if($request->has("q"))
        {
            $list = $item->users()->where(function ($q) use ($request){
                $q->where('first_name', 'LIKE', '%'.$request['q'].'%')
                    ->orWhere('last_name', 'LIKE', '%'.$request['q'].'%')
                    ->orWhere('middle_name', 'LIKE', '%'.$request['q'].'%')
                    ->orWhere('display_name', 'LIKE', '%'.$request['q'].'%')
                    ->orWhere(\DB::raw('concat(first_name," ",middle_name," ",last_name)'), 'like', '%'.$request['q'].'%')
                    ->orWhere(\DB::raw('concat(first_name," ",last_name)'), 'like', '%'.$request['q'].'%')
                    ->orWhere('email', 'LIKE', '%'.$request['q'].'%');
            });
        } else
        {
            $list = $item->users();
        }

        $list->orderBy('pivot_is_active', 'desc');

        $list = $list->paginate(config('vaahcms.per_page'));

        foreach ($list as $user){

            $data = self::getPivotData($user->pivot);

            $user['json'] = $data;
            $user['json_length'] = count($data);
        }

        $response['data']['list'] = $list;
        $response['status'] = 'success';

        return $response;


    }
    //-------------------------------------------------


    //-------------------------------------------------
    public static function postStore($request,$id)
    {

        if(!\Auth::user()->hasPermission('can-update-roles'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }


        $input = $request->item;


        $validation = static::validation($input);
        if(isset($validation['status']) && $validation['status'] == 'failed')
        {
            return $validation;
        }

        // check if name exist
        $user = static::where('id','!=',$input['id'])->where('name',$input['name'])->first();

        if($user)
        {
            $response['status'] = 'failed';
            $response['errors'][] = "This name is already exist.";
            return $response;
        }


        // check if slug exist
        $user = static::where('id','!=',$input['id'])->where('slug',$input['slug'])->first();

        if($user)
        {
            $response['status'] = 'failed';
            $response['errors'][] = "This slug is already exist.";
            return $response;
        }

        $update = static::where('id',$id)->withTrashed()->first();

        $update->name = $input['name'];
        $update->slug = Str::slug($input['slug']);
        $update->details = $input['details'];
        $update->is_active = $input['is_active'];

        $update->save();


        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = 'Data updated.';

        return $response;

    }
    //-------------------------------------------------
    public static function bulkStatusChange($request)
    {

        if(!\Auth::user()->hasPermission('can-manage-roles') &&
            !\Auth::user()->hasPermission('can-update-roles'))
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
            $role = static::where('id',$id)->withTrashed()->first();

            if($role->deleted_at){
                continue ;
            }

            if($request['data']){
                $role->is_active = $request['data']['status'];
            }else{
                if($role->is_active == 1){
                    $role->is_active = 0;
                }else{
                    $role->is_active = 1;
                }
            }
            $role->save();
        }

        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = 'Action was successful';

        return $response;


    }
    //-------------------------------------------------
    public static function bulkTrash($request)
    {

        if(!\Auth::user()->hasPermission('can-update-roles'))
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


        foreach($request->inputs as $id)
        {
            $permission = static::withTrashed()->where('id', $id)->first();
            if($permission)
            {
                $permission->is_active = 0;
                $permission->save();
                $permission->delete();
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

        if(!\Auth::user()->hasPermission('can-update-roles'))
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
            $item = Role::withTrashed()->where('id', $id)->first();
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
    public static function bulkDelete($request)
    {

        if(!\Auth::user()->hasPermission('can-update-roles') ||
            !\Auth::user()->hasPermission('can-delete-roles'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

        if(!\Auth::user()->hasPermission('can-update-roles'))
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

                $item->permissions()->detach();

                $item->users()->detach();

                $item->forceDelete();

            }
        }

        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = 'Action was successful';

        return $response;


    }
    //-------------------------------------------------
    public static function bulkChangePermissionStatus($request)
    {

        if(!\Auth::user()->hasPermission('can-manage-roles') &&
            !\Auth::user()->hasPermission('can-update-roles'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

        $inputs = $request->all();

        $item = Role::where('id',$inputs['inputs']['id'])->withTrashed()->first();

        if($item->id == 1)
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Admin permission can not be changed';
            return response()->json($response);

        }

        $data = [
            'is_active' => $inputs['data']['is_active'],
            'updated_by' => Auth::user()->id,
            'updated_at' => \Illuminate\Support\Carbon::now()
        ];

        if($inputs['inputs']['permission_id']){
            $pivot = $item->permissions->find($inputs['inputs']['permission_id'])->pivot;

            if($pivot->is_active === null && !$pivot->created_by){
                $data['created_by'] = Auth::user()->id;
                $data['created_at'] = \Illuminate\Support\Carbon::now();
            }

            $item->permissions()->updateExistingPivot($inputs['inputs']['permission_id'], $data);
        }else{
            $item->permissions()
                ->newPivotStatement()
                ->where('vh_role_id', '=', $item->id)
                ->update($data);
//            $item->permissions()->updateExistingPivot('', array('is_active' => $inputs['data']['is_active']));
        }


        Role::recountRelations();
            $response['messages'] = [];
    }
    //-------------------------------------------------
    public static function bulkChangeUserStatus($request)
    {

        if(!\Auth::user()->hasPermission('can-manage-roles') &&
            !\Auth::user()->hasPermission('can-update-roles'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

        $inputs = $request->all();

        $item = Role::where('id',$inputs['inputs']['id'])->withTrashed()->first();

        $data = [
            'is_active' => $inputs['data']['is_active'],
            'updated_by' => Auth::user()->id,
            'updated_at' => \Illuminate\Support\Carbon::now()
        ];


        if($inputs['inputs']['user_id']){

            $pivot = $item->users->find($inputs['inputs']['user_id'])->pivot;

            if($pivot->is_active === null && !$pivot->created_by){
                $data['created_by'] = Auth::user()->id;
                $data['created_at'] = \Illuminate\Support\Carbon::now();
            }

            $item->users()->updateExistingPivot($inputs['inputs']['user_id'], $data);
        }else{
            $item->users()
                ->newPivotStatement()
                ->where('vh_role_id', '=', $item->id)
                ->update($data);
        }
        Role::recountRelations();
        $response['messages'] = [];
    }
    //-------------------------------------------------
    public static function bulkPermissionStatusChange($request)
    {

        if(!\Auth::user()->hasPermission('can-manage-roles') &&
            !\Auth::user()->hasPermission('can-update-roles'))
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
            $perm = Permission::where('id',$id)->withTrashed()->first();

            if($perm->deleted_at){
                continue ;
            }

            if($request['data']){
                $perm->is_active = $request['data']['status'];
            }else{
                if($perm->is_active == 1){
                    $perm->is_active = 0;
                }else{
                    $perm->is_active = 1;
                }
            }
            $perm->save();
        }

        $response['status'] = 'success';
        $response['data'] = [];

        return $response;

    }
    //-------------------------------------------------


    //-------------------------------------------------

    public static function getModuleSections($request)
    {

        $item = Permission::where('module',$request->module)->withTrashed()->select('section')->get()->unique('section');

        $response['status'] = 'success';
        $response['data'] = $item;

        return $response;


    }

    //-------------------------------------------------

    public static function validation($inputs)
    {

        $rules = array(
            'name' => 'required|max:150',
            'slug' => 'required|max:150',
            'details' => 'required|max:255',
            'is_active' => 'required',
        );

        $messages = [
            'is_active.required' => 'The is active field is required.',
            'details.required' => 'The detail field is required.'
        ];

        $validator = \Validator::make( $inputs, $rules, $messages);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }


    }
    //-------------------------------------------------
    public static function getActiveRoles()
    {
        $list = static::where('is_active', 1)->get();
        return $list;
    }
    //-------------------------------------------------

    //-------------------------------------------------
    public static function getPivotData($pivot)
    {

        $data = array();

        if($pivot->created_by && User::find($pivot->created_by)){
            $data['Created by'] = User::find($pivot->created_by)->name;
        }

        if($pivot->updated_by && User::find($pivot->updated_by)){
            $data['Updated by'] = User::find($pivot->updated_by)->name;
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
    //-------------------------------------------------


}
