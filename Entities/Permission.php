<?php namespace WebReinvent\VaahCms\Entities;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Traits\CrudWithUuidObservantTrait;

class Permission extends Model {

    use SoftDeletes;
    use CrudWithUuidObservantTrait;
    //-------------------------------------------------
    protected $table = 'vh_permissions';
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
        return $this->belongsTo('WebReinvent\VaahCms\Entities\User',
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
    public function roles() {
        return $this->belongsToMany( 'WebReinvent\VaahCms\Entities\Role',
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
        $roles_ids = Permission::getPermissionRoleIds($id);

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

        $permissions_list = Permission::all();

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

        $permissions = Permission::all()->pluck('id')->toArray();

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
        $list = Permission::withTrashed()->select('id')->get();

        if($list)
        {
            foreach ($list as $item)
            {
                $roles_ids = Permission::getPermissionRoleIds($item->id);
                $item->count_roles = count($roles_ids);
                $item->count_users = Permission::countUsers($item->id);
                $item->save();
            }
        }

    }
    //-------------------------------------------------
    public static function getList($request)
    {

        if(isset($request->recount) && $request->recount == true)
        {
            Permission::syncPermissionsWithRoles();
            Permission::recountRelations();
        }

        $list = Permission::orderBy('id', 'desc');

        if($request['trashed'] == 'true')
        {
            $list->withTrashed();
        }

        if(isset($request->from) && isset($request->to))
        {
            $list->betweenDates($request['from'],$request['to']);
        }

        if(isset($request['filter']) &&  $request['filter'])
        {
            if($request['filter'] == 'active')
            {
                $list->where('is_active',1);
            }elseif($request['filter'] == 'inactive'){
                $list->whereNull('is_active')->orWhere('is_active',0);
            }else{
                if(isset($request['section']) &&  $request['section']){
                    $list->where('module',$request['filter'])->where('section',$request['section']);
                }else{
                    $list->where('module',$request['filter']);
                }

            }
        }

        if(isset($request->q))
        {
            $list->where(function ($q) use ($request){
                $q->where('name', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('slug', 'LIKE', '%'.$request->q.'%');
            });
        }

        $data['list'] = $list->paginate(config('vaahcms.per_page'));

        $countRole = Role::all()->count();
        $countUser = User::all()->count();

        $response['status'] = 'success';
        $response['data'] = $data;
        $response['data']['totalRole'] = $countRole;
        $response['data']['totalUser'] = $countUser;

        return $response;
    }

    //-------------------------------------------------

    public static function getItem($id)
    {

        $item = Permission::where('id', $id)->with(['createdByUser', 'updatedByUser', 'deletedByUser'])
            ->withTrashed()->first();

        $response['status'] = 'success';
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

        $response['status'] = 'success';

        return $response;


    }
    //-------------------------------------------------
    public static function postStore($request,$id)
    {

        $input = $request->item;


        $validation = static::validation($input);
        if(isset($validation['status']) && $validation['status'] == 'failed')
        {
            return $validation;
        }

        $update = static::where('id',$id)->withTrashed()->first();

        $update->name = $input['name'];
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

        if(!\Auth::user()->hasPermission('can-manage-permissions') &&
            !\Auth::user()->hasPermission('can-update-permissions'))
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

        $response['status'] = 'success';
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
        $response['messages'][] = trans('vaahcms-general.action_successful');

        return $response;


    }

    //-------------------------------------------------
    public static function bulkTrash($request)
    {

        if(!\Auth::user()->hasPermission('can-update-permissions'))
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
        $response['messages'][] = trans('vaahcms-general.action_successful');

        return $response;


    }
    //-------------------------------------------------
    public static function bulkRestore($request)
    {

        if(!\Auth::user()->hasPermission('can-update-permissions'))
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
            $item = static::withTrashed()->where('id', $id)->first();
            if(isset($item) && isset($item->deleted_at))
            {
                $item->restore();
            }
        }

        $response['status'] = 'success';
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
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

        $inputs = $request->all();

        $item = Permission::where('id',$inputs['inputs']['id'])->withTrashed()->first();

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
        Permission::recountRelations();
        Role::recountRelations();
        $response['status'] = 'success';
        $response['data'] = [];

        return $response;


    }
    //-------------------------------------------------

    public static function validation($inputs)
    {

        $rules = array(
            'id' => 'required',
            'name' => 'required|max:150',
            'details' => 'required|max:255',
            'is_active' => 'required',
        );

        $messages = [
            'is_active.required' => trans('vaahcms-general.is_active_required')
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

    public static function getModuleSections($request)
    {

        $item = Permission::where('module',$request->filter)->withTrashed()->select('section')->get()->unique('section');

        $response['status'] = 'success';
        $response['data'] = $item;

        return $response;


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
}
