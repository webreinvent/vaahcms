<?php namespace WebReinvent\VaahCms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
    public function roles() {
        return $this->belongsToMany( 'WebReinvent\VaahCms\Entities\Role',
            'vh_role_permissions', 'vh_permission_id', 'vh_role_id'
        )->withPivot('is_active');
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

        if(isset($request['filter']) &&  $request['filter'])
        {
            if($request['filter'] == '1')
            {
                $list->where('is_active',$request['filter']);
            }elseif($request['filter'] == '10'){
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

        $data['list'] = $list->paginate(2);

        $response['status'] = 'success';
        $response['data'] = $data;

        return $response;
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
            $reg = static::find($id);
            if($request['data']){
                $reg->is_active = $request['data']['status'];
            }else{
                if($reg->is_active == 1){
                    $reg->is_active = 0;
                }else{
                    $reg->is_active = 1;
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
            $item = static::where('id', $id)->withTrashed()->first();
            if($item)
            {

                $item->forceDelete();

            }
        }

        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = 'Action was successful';

        return $response;


    }

    //-------------------------------------------------
    public static function bulkTrash($request)
    {

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
        $response['messages'][] = 'Action was successful';

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

        $permissions = Permission::all()->pluck('id')->toArray();

        $roles = Role::all();

        if($roles)
        {
            foreach ($roles as $role)
            {
                if($role->id == 1)
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
    public static function updateDetail($request,$id)
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

    public static function validation($inputs)
    {

        $rules = array(
            'id' => 'required',
            'name' => 'required',
            'details' => 'required',
            'is_active' => 'required',
        );

        $messages = [
            'is_active.required' => 'The is active field is required.'
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

    public static function getRoles($request,$id)
    {

        $item = Permission::find($id);
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

        $response['data']['list'] = $list;

        $response['status'] = 'success';

        return $response;


    }

    //-------------------------------------------------

    public static function getDetail($id)
    {

        $item = Permission::where('id', $id)->with(['createdByUser', 'updatedByUser', 'deletedByUser'])
            ->withTrashed()->first();

        $response['status'] = 'success';
        $response['data'] = $item;

        return $response;


    }

    //-------------------------------------------------

    public static function getModuleList()
    {

        $item = Permission::withTrashed()->select('module')->get()->unique('module');

        return $item;


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
}
