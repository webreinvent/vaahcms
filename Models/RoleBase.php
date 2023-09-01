<?php namespace WebReinvent\VaahCms\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Models\Permission;
use WebReinvent\VaahCms\Models\User;
use WebReinvent\VaahCms\Traits\CrudWithUuidObservantTrait;

class RoleBase extends Model {

    use SoftDeletes;
    use CrudWithUuidObservantTrait;

    //-------------------------------------------------
    protected $connection= 'mysql';
    //-------------------------------------------------
    protected $table = 'vh_roles';
    //-------------------------------------------------
    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
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



    //-------------------------------------------------
    protected function serializeDate(DateTimeInterface $date)
    {
        $date_time_format = config('settings.global.datetime_format');

        return $date->format($date_time_format);

    }
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

        $role = self::withTrashed()->where('id', $id)->first();

        if(!$role)
        {
            return 0;
        }

        return $role->users()->wherePivot('is_active', 1)->count();
    }
    //-------------------------------------------------
    public static function countPermissions($id)
    {
        $role = self::withTrashed()->where('id', $id)->first();
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
        $list = self::withTrashed()->select('id')->get();

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
        $all_roles = self::select('id')->get();

        if(!$all_roles)
        {
            return false;
        }

        foreach ($all_roles as $role)
        {
            $role->users()->syncWithoutDetaching($all_users);
        }


        //enable all roles for super admin users
        $super_admin_role = self::slug('super-administrator')->first();
        $super_admin_users = $super_admin_role->users()->wherePivot('is_active', 1)
            ->get()
            ->pluck('id')
            ->toArray();
        $pivotData = array_fill(0, count($super_admin_users), ['is_active' => 1]);
        $syncData  = array_combine($super_admin_users, $pivotData);
        $super_admin_role->users()->syncWithoutDetaching($syncData);


        return true;

    }
    //-------------------------------------------------
    public static function createItem($request)
    {

        if(!\Auth::user()->hasPermission('can-create-roles'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

        $inputs = $request->all();

        $validation = self::validation($inputs);

        if (isset($validation['success']) && !$validation['success']) {
            return $validation;
        }

        // check if name exist
        $user = self::withTrashed()->where('name',$inputs['name'])->first();

        if ($user) {
            $response['success'] = false;
            $response['errors'][] = "This name is already exist.";
            return $response;
        }


        // check if slug exist
        $user = self::withTrashed()->where('slug',$inputs['slug'])->first();

        if($user)
        {
            $response['success'] = false;
            $response['errors'][] = "This slug is already exist.";
            return $response;
        }

        $role = new self();
        $role->fill($inputs);
        $role->slug = Str::slug($inputs['slug']);
        $role->save();

        Permission::syncPermissionsWithRoles();
        self::syncRolesWithUsers();
        self::recountRelations();

        $response['success'] = true;
        $response['data'] = $role;
        $response['messages'][] = trans('vaahcms-general.saved_successfully');
        return $response;

    }
    //-------------------------------------------------
    public function scopeGetSorted($query, $filter)
    {

        if(!isset($filter['sort']))
        {
            return $query->orderBy('id', 'desc');
        }

        $sort = $filter['sort'];


        $direction = Str::contains($sort, ':');

        if(!$direction)
        {
            return $query->orderBy($sort, 'asc');
        }

        $sort = explode(':', $sort);

        return $query->orderBy($sort[0], $sort[1]);
    }
    //-------------------------------------------------
    public function scopeIsActiveFilter($query, $filter)
    {

        if(!isset($filter['is_active'])
            || is_null($filter['is_active'])
            || $filter['is_active'] === 'null'
        )
        {
            return $query;
        }
        $is_active = $filter['is_active'];

        if($is_active === 'true' || $is_active === true)
        {
            return $query->whereNotNull('is_active');
        } else{
            return $query->whereNull('is_active');
        }

    }
    //-------------------------------------------------
    public function scopeTrashedFilter($query, $filter)
    {

        if(!isset($filter['trashed']))
        {
            return $query;
        }
        $trashed = $filter['trashed'];

        if($trashed === 'include')
        {
            return $query->withTrashed();
        } else if($trashed === 'only'){
            return $query->onlyTrashed();
        }

    }
    //-------------------------------------------------
    public function scopeSearchFilter($query, $filter)
    {

        if(!isset($filter['q']))
        {
            return $query;
        }
        $search = $filter['q'];
        $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('slug', 'LIKE', '%' . $search . '%');
        });

    }
    //-------------------------------------------------
    public static function getList($request)
    {

        if (isset($request->recount) && $request->recount == true) {
            Permission::syncPermissionsWithRoles();
            self::syncRolesWithUsers();
            self::recountRelations();
        }

        $list = self::getSorted($request->filter);
        $list->isActiveFilter($request->filter);
        $list->trashedFilter($request->filter);
        $list->searchFilter($request->filter);

        $rows = config('vaahcms.per_page');

        if($request->has('rows')) {
            $rows = $request->rows;
        }

        $list = $list->paginate($rows);

        $countPermissions = Permission::count();
        $countUsers = User::count();

        $response['success'] = true;
        $response['data'] = $list;
        $response['totalPermissions'] = $countPermissions;
        $response['totalUsers'] = $countUsers;

        return $response;
    }

    //-------------------------------------------------
    public static function getItem($id)
    {

        $item = self::where('id', $id)->with(['createdByUser', 'updatedByUser', 'deletedByUser'])->withTrashed()->first();

        $response['success'] = true;
        $response['data'] = $item;

        return $response;

    }
    //-------------------------------------------------
    public static function getRolePermission($request,$id)
    {
        $item = self::withTrashed()->where('id', $id)->first();
        $response['data']['item'] = $item;

        if ($request->has('q'))
        {
            $list = $item->permissions()->where(function ($q) use ($request){
                $q->where('name', 'LIKE', '%'. $request->q .'%')
                    ->orWhere('slug', 'LIKE', '%'. $request->q .'%');
            });
        } else {
            $list = $item->permissions();
        }

        if (isset($request['module'])) {
            $list->where('module',$request['module']);
        }

        if (isset($request['section'])) {
            $list->where('section',$request['section']);
        }

        $list->orderBy('pivot_is_active', 'desc');

        $rows = config('vaahcms.per_page');

        if ($request->has('rows')) {
            $rows = $request->rows;
        }

        $list = $list->paginate($rows);

        foreach ($list as $permission){

            $data = self::getPivotData($permission->pivot);

            $permission['json'] = $data;
            $permission['json_length'] = count($data);
        }


        $response['data']['list'] = $list;
        $response['success'] = true;

        return $response;
    }
    //-------------------------------------------------
    public static function getRoleUser($request,$id)
    {
        $item = self::withTrashed()->where('id', $id)->first();
        $response['data']['item'] = $item;

        if ($request->has("q")) {
            $list = $item->users()->where(function ($q) use ($request){
                $q->where('first_name', 'LIKE', '%' . $request->q . '%')
                    ->orWhere('middle_name', 'LIKE', '%' . $request->q . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $request->q . '%')
                    ->orWhere(DB::raw('concat(first_name," ",middle_name," ",last_name)'), 'like', '%' . $request->q . '%')
                    ->orWhere(DB::raw('concat(first_name," ",last_name)'), 'like', '%' . $request->q . '%')
                    ->orWhere('display_name', 'like', '%' . $request->q . '%')
                    ->orWhere('email', 'LIKE', '%' . $request->q .'%');
            });
        } else {
            $list = $item->users();
        }

        $list->orderBy('pivot_is_active', 'desc');

        $rows = config('vaahcms.per_page');

        if ($request->has('rows')) {
            $rows = $request->rows;
        }

        $list = $list->paginate($rows);

        foreach ($list as $user) {
            $data = self::getPivotData($user->pivot);

            $user['json'] = $data;
            $user['json_length'] = count($data);
        }

        $response['data']['list'] = $list;
        $response['success'] = true;

        return $response;
    }
    //-------------------------------------------------


    //-------------------------------------------------
    public static function postStore($request,$id)
    {
        if(!\Auth::user()->hasPermission('can-update-roles'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }


        $input = $request->item;

        $validation = static::validation($input);
        if(isset($validation['success']) && !$validation['success'])
        {
            return $validation;
        }

        // check if name exist
        $user = static::where('id','!=',$input['id'])->where('name',$input['name'])->first();

        if($user)
        {
            $response['success'] = false;
            $response['errors'][] = "This name is already exist.";
            return $response;
        }


        // check if slug exist
        $user = static::where('id','!=',$input['id'])->where('slug',$input['slug'])->first();

        if($user)
        {
            $response['success'] = false;
            $response['errors'][] = "This slug is already exist.";
            return $response;
        }

        $update = static::where('id',$id)->withTrashed()->first();

        $update->name = $input['name'];
        $update->slug = Str::slug($input['slug']);
        $update->details = $input['details'];
        $update->is_active = $input['is_active'];

        $update->save();


        $response['success'] = true;
        $response['data'] = [];
        $response['messages'][] = 'Data updated.';

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
            $permission = static::withTrashed()->where('id', $id)->first();
            if($permission)
            {
                $permission->is_active = 0;
                $permission->save();
                $permission->delete();
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
    public static function deleteList($request): array
    {
        $inputs = $request->all();

        $rules = array(
            'type' => 'required',
            'items' => 'required',
        );

        $messages = array(
            'type.required' => 'Action type is required',
            'items.required' => 'Select items',
        );

        $validator = \Validator::make($inputs, $rules, $messages);

        if ($validator->fails()) {
            $errors = errorsToArray($validator->errors());
            $response['failed'] = true;
            $response['errors'] = $errors;

            return $response;
        }

        $items_id = collect($inputs['items'])->pluck('id')->toArray();

        foreach($items_id as $id) {
            $item = static::where('id', $id)->withTrashed()->first();

            if ($item) {
                $item->permissions()->detach();
                $item->users()->detach();
                $item->forceDelete();
            }
        }

        $response['success'] = true;
        $response['data'] = true;
        $response['messages'][] = trans('vaahcms-general.action_successful');

        return $response;
    }
    //-------------------------------------------------
    public static function bulkChangePermissionStatus($request)
    {

        $inputs = $request->all();

        $item = self::where('id',$inputs['inputs']['id'])->withTrashed()->first();

        if($item->id == 1)
        {
            $response['success'] = false;
            $response['errors'][] = 'Super Admin permission can not be changed';
            return response()->json($response);

        }

        $data = [
            'is_active' => $inputs['data']['is_active'],
            'updated_by' => Auth::user()->id,
            'updated_at' => \Illuminate\Support\Carbon::now()
        ];

        if ($inputs['inputs']['permission_id']) {
            $pivot = $item->permissions->find($inputs['inputs']['permission_id'])->pivot;

            if ($pivot->is_active === null && !$pivot->created_by) {
                $data['created_by'] = Auth::user()->id;
                $data['created_at'] = \Illuminate\Support\Carbon::now();
            }

            $item->permissions()->updateExistingPivot($inputs['inputs']['permission_id'], $data);
        } else {
            $item->permissions()
                ->newPivotStatement()
                ->where('vh_role_id', '=', $item->id)
                ->update($data);
//            $item->permissions()->updateExistingPivot('', array('is_active' => $inputs['data']['is_active']));
        }

        self::recountRelations();
        $response['messages'] = [];
    }
    //-------------------------------------------------
    public static function bulkChangeUserStatus($request)
    {

        $inputs = $request->all();

        $item = self::where('id',$inputs['inputs']['id'])->withTrashed()->first();

        $data = [
            'is_active' => $inputs['data']['is_active'],
            'updated_by' => Auth::user()->id,
            'updated_at' => \Illuminate\Support\Carbon::now()
        ];


        if ($inputs['inputs']['user_id']) {

            $pivot = $item->users->find($inputs['inputs']['user_id'])->pivot;

            if ($pivot->is_active === null && !$pivot->created_by) {
                $data['created_by'] = Auth::user()->id;
                $data['created_at'] = \Illuminate\Support\Carbon::now();
            }

            $item->users()->updateExistingPivot($inputs['inputs']['user_id'], $data);
        } else {
            $item->users()
                ->newPivotStatement()
                ->where('vh_role_id', '=', $item->id)
                ->update($data);
        }
        self::recountRelations();
        $response['messages'] = [];
    }
    //-------------------------------------------------
    public static function bulkPermissionStatusChange($request)
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

        $response['success'] = true;
        $response['data'] = [];

        return $response;

    }
    //-------------------------------------------------


    //-------------------------------------------------

    public static function getModuleSections($request)
    {
        $sections = Permission::where('module', $request->module)->withTrashed()->get()->unique('section')->pluck('section');

        $response['success'] = true;
        $response['data'] = $sections;

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
            $response['success'] = false;
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
            $data['created_by'] = User::find($pivot->created_by)->name;
        }

        if($pivot->updated_by && User::find($pivot->updated_by)){
            $data['updated_by'] = User::find($pivot->updated_by)->name;
        }

        if($pivot->created_at){
            $data['created_at'] = date('d-m-Y H:i:s', strtotime($pivot->created_at));
        }

        if($pivot->updated_at){
            $data['updated_at'] = date('d-m-Y H:i:s', strtotime($pivot->updated_at));
        }

        return $data;

    }
    //-------------------------------------------------
    //-------------------------------------------------


}
