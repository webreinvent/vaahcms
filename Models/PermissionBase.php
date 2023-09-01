<?php namespace WebReinvent\VaahCms\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Models\Role;
use WebReinvent\VaahCms\Models\User;
use WebReinvent\VaahCms\Traits\CrudWithUuidObservantTrait;

class PermissionBase extends Model {

    use SoftDeletes;
    use CrudWithUuidObservantTrait;
    //-------------------------------------------------
    protected $connection= 'mysql';
    //-------------------------------------------------
    protected $table = 'vh_permissions';
    //-------------------------------------------------
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'module',
        'section',
        'details',
        'count_users',
        'count_roles',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by'
    ];




    //-------------------------------------------------
    protected $appends  = [

    ];

    //-------------------------------------------------

    protected $excluded_columns = [];

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
        $query->where('vh_permissions.is_active', 1);
    }
    //-------------------------------------------------
    //-------------------------------------------------
    public function createdByUser()
    {
        return $this->belongsTo(' WebReinvent\VaahCms\Models\User',
            'created_by', 'id'
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
    public function updatedByUser()
    {
        return $this->belongsTo(' WebReinvent\VaahCms\Models\User',
            'updated_by', 'id'
        )->select('id', 'uuid', 'first_name', 'last_name', 'email');
    }

    //-------------------------------------------------
    public function deletedByUser()
    {
        return $this->belongsTo(' WebReinvent\VaahCms\Models\User',
            'deleted_by', 'id'
        )->select('id', 'uuid', 'first_name', 'last_name', 'email');
    }
    //-------------------------------------------------
    public function roles() {
        return $this->belongsToMany( Role::class,
            'vh_role_permissions', 'vh_permission_id', 'vh_role_id'
        )->withPivot('is_active',
            'created_by',
            'created_at',
            'updated_by',
            'updated_at');
    }
    //-------------------------------------------------
    public static function getPermissionRoleIds($id)
    {
        $roles = static::getPermissionRoles($id);
        return $roles->pluck('id')->toArray();
    }
    //-------------------------------------------------
    public static function countUsers($id)
    {
        $roles_ids = self::getPermissionRoleIds($id);

        if(!$roles_ids || !is_array($roles_ids))
        {
            return false;
        }

        $users = User::whereHas('roles', function ($q) use ($roles_ids){
            $q->whereIn('vh_roles.id', $roles_ids);
        })->count();

        return $users;
    }
    //-------------------------------------------------
    public static function syncPermissionsWithRoles()
    {

        $permissions_list = self::all();

        if($permissions_list){
            foreach ($permissions_list as $permission){
                if(!$permission->uuid){
                    $permission->uuid = Str::uuid();
                }

                if(!$permission->slug){
                    $permission->slug = Str::slug($permission->name);
                }

                $permission->save();

            }
        }

        $permissions = self::all()->pluck('id')->toArray();

        $roles = Role::all();

        if($roles)
        {
            foreach ($roles as $role)
            {

                if($role->slug == 'super-administrator')
                {
                    $pivotData = array_fill(0, count($permissions), ['is_active' => 1]);
                    $syncData  = array_combine($permissions, $pivotData);
                    $role->permissions()->syncWithoutDetaching($syncData);
                } else
                {
                    $role->permissions()->syncWithoutDetaching($permissions);
                }
            }
        }

    }
    //-------------------------------------------------
    public static function recountRelations()
    {
        $list = self::withTrashed()->select('id')->get();

        if($list)
        {
            foreach ($list as $item)
            {
                $roles_ids = self::getPermissionRoleIds($item->id);
                $item->count_roles = count($roles_ids);
                $item->count_users = self::countUsers($item->id);
                $item->save();
            }
        }

    }
    //-------------------------------------------------
    public static function getList($request)
    {
        if (isset($request->recount) && $request->recount == true) {
            self::syncPermissionsWithRoles();
            self::recountRelations();
        }

        $list = self::getSorted($request->filter);
        $list->isActiveFilter($request->filter);
        $list->trashedFilter($request->filter);
        $list->searchFilter($request->filter);

        $rows = config('vaahcms.per_page');

        if ($request->has('rows')) {
            $rows = $request->rows;
        }

        $total_roles = Role::count();
        $total_users = User::count();
        $list = $list->paginate($rows);

        $response['success'] = true;
        $response['data'] = $list;
        $response['total_roles'] = $total_roles;
        $response['total_users'] = $total_users;

        return $response;
    }

    //-------------------------------------------------

    public static function getItem($id)
    {

        $item = self::where('id', $id)->with(['createdByUser', 'updatedByUser', 'deletedByUser'])
            ->withTrashed()->first();

        $response['success'] = true;
        $response['data'] = $item;

        return $response;


    }
    //-------------------------------------------------
    public static function getPermissionRoles($id)
    {

        $item = Permission::withTrashed()->where('id', $id)->first();

        if(!$item)
        {
            return false;
        }

        return $item->roles()->wherePivot('is_active', 1)->get();
    }

    //-------------------------------------------------

    public static function getItemRoles($request,$id)
    {

        $item = Permission::where('id',$id)->withTrashed()->first();
        $response['data']['permission'] = $item;


        if($request->has("q"))
        {
            $list = $item->roles()->where(function ($q) use ($request){
                $q->where('name', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('slug', 'LIKE', '%'.$request->q.'%');
            });
        } else {
            $list = $item->roles();
        }

        $list->orderBy('pivot_is_active', 'desc');

        $rows = config('vaahcms.per_page');

        if ($request->has('rows')) {
            $rows = $request->rows;
        }

        $list = $list->paginate($rows);

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
    public static function postStore($request,$id)
    {

        $input = $request->item;


        $validation = static::validation($input);
        if(isset($validation['success']) && !$validation['success'])
        {
            return $validation;
        }

        $update = static::where('id',$id)->withTrashed()->first();

        $update->name = $input['name'];
        $update->details = $input['details'];
        $update->is_active = $input['is_active'];

        $update->save();


        $response['success'] = true;
        $response['data'] = [];
        $response['messages'][] = 'Data updated.';

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

        $items_ids = collect($inputs['items'])->pluck('id')->toArray();

        foreach ($items_ids as $id) {
            $item = static::where('id', $id)->withTrashed()->first();

            if ($item) {
                $item->roles()->detach();
                $item->forceDelete();
            }
        }

        $response['success'] = true;
        $response['data'] = true;
        $response['messages'][] = 'Action was successful.';

        return $response;
    }
    //-------------------------------------------------
    public static function bulkStatusChange($request)
    {

        if(!\Auth::user()->hasPermission('can-manage-permissions') &&
            !\Auth::user()->hasPermission('can-update-permissions'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

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
            $perm = static::where('id',$id)->withTrashed()->first();

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
        $response['messages'][] = trans('vaahcms-general.action_successful');

        return $response;
    }
    //-------------------------------------------------
    public static function bulkDelete($request)
    {

        if(!\Auth::user()->hasPermission('can-update-permissions') ||
            !\Auth::user()->hasPermission('can-delete-permissions'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

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
            $item = static::where('id', $id)->withTrashed()->first();
            if($item)
            {

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
    public static function bulkTrash($request)
    {

        if(!\Auth::user()->hasPermission('can-update-permissions'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

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

        if(!\Auth::user()->hasPermission('can-update-permissions'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

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
            $item = static::withTrashed()->where('id', $id)->first();
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

        if(!\Auth::user()->hasPermission('can-manage-permissions') &&
            !\Auth::user()->hasPermission('can-update-permissions'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

        $inputs = $request->all();

        $item = self::where('id',$inputs['inputs']['id'])->withTrashed()->first();

        $data = [
            'is_active' => $inputs['data']['is_active'],
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now()
        ];

        if($inputs['inputs']['role_id']){
            $pivot = $item->roles->find($inputs['inputs']['role_id'])->pivot;

            if($pivot->is_active === null && !$pivot->created_by){
                $data['created_by'] = Auth::user()->id;
                $data['created_at'] = Carbon::now();
            }

            $item->roles()->updateExistingPivot($inputs['inputs']['role_id'], $data);
        }else{
            $item->roles()
                ->newPivotStatement()
                ->where('vh_permission_id', '=', $item->id)
                ->update($data);
        }


        $item->save();
        self::recountRelations();
        Role::recountRelations();
        $response['success'] = true;
        $response['data'] = [];

        return $response;


    }
    //-------------------------------------------------

    public static function validation($inputs)
    {
        $rules = array(
            'name' => 'required|max:150',
            'slug' => 'required|max:150',
        );

        $validator = \Validator::make($inputs, $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $response['success'] = false;
            $response['messages'] = $messages->all();
            return $response;
        }

        $response['success'] = true;
        return $response;
    }

    //-------------------------------------------------

    public static function getModuleSections($request)
    {

        $item = self::where('module',$request->filter)->withTrashed()->select('section')->get()->unique('section');

        $response['success'] = true;
        $response['data'] = $item;

        return $response;


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
}
