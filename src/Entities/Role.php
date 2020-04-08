<?php namespace WebReinvent\VaahCms\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Traits\CrudObservantTrait;

class Role extends Model {

    use SoftDeletes;
    use CrudObservantTrait;

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
    public function scopeSlug( $query, $slug ) {
        return $query->where( 'slug', $slug );
    }
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
    //-------------------------------------------------
   
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
    //-------------------------------------------------
    //-------------------------------------------------
    public function permissions() {
        return $this->belongsToMany( 'WebReinvent\VaahCms\Entities\Permission',
            'vh_role_permissions', 'vh_role_id', 'vh_permission_id'
        )->withPivot('is_active');
    }
    //-------------------------------------------------
    public function users() {
        return $this->belongsToMany( 'WebReinvent\VaahCms\Entities\User',
            'vh_user_roles', 'vh_role_id', 'vh_user_id'
        )->withPivot('is_active');
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

        return $role->permissions()->wherePivot('is_active', 1)->count();
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
        $admin_users = $admin_role->users()->get()->pluck('id')->toArray();
        $pivotData = array_fill(0, count($admin_users), ['is_active' => 1]);
        $syncData  = array_combine($admin_users, $pivotData);
        $admin_role->users()->syncWithoutDetaching($syncData);


        return true;

    }
    //-------------------------------------------------
    public static function getDetail($id)
    {
        $item = Role::where('id', $id)->with(['createdByUser', 'updatedByUser', 'deletedByUser'])->withTrashed()->first();

        $response['status'] = 'success';
        $response['data'] = $item;

        return $response;

    }
    //-------------------------------------------------

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
        $update->slug = Str::slug($input['slug']);
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
            'name' => 'required',
            'slug' => 'required',
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

        $list->orderBy('pivot_is_active', 'desc');

        $list = $list->paginate(config('vaahcms.per_page'));


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
                $q->where('first_name', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('last_name', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('email', 'LIKE', '%'.$request->q.'%');
            });
        } else
        {
            $list = $item->users();
        }

        $list->orderBy('pivot_is_active', 'desc');

        $list = $list->paginate(config('vaahcms.per_page'));

        $response['data']['list'] = $list;
        $response['status'] = 'success';

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


        $response['status'] = 'success';
        $response['data'] = $data;

        return $response;


    }
    //-------------------------------------------------
    public static function create($request)
    {

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
        $role->save();

        Permission::syncPermissionsWithRoles();
        Role::syncRolesWithUsers();
        Role::recountRelations();

        $response['status'] = 'success';
        $response['data']['item'] = $role;
        return $response;

    }
    //-------------------------------------------------


}
