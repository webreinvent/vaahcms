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
    public function setSlugAttribute( $value ) {
        $this->attributes['slug'] = Str::slug( $value );
    }
    //-------------------------------------------------
    public function getNameAttribute($value) {
        return ucwords($value);
    }
    //-------------------------------------------------
    public function scopeActive( $query ) {
        return $query->where( 'is_active', 1 );
    }

    //-------------------------------------------------
    public function scopeInactive( $query ) {
        return $query->where( 'is_active', 0 );
    }

    //-------------------------------------------------
    public function scopeSlug( $query, $slug ) {
        return $query->where( 'slug', $slug );
    }
    //-------------------------------------------------
    public function scopeCreatedBy( $query, $user_id ) {
        return $query->where( 'created_by', $user_id );
    }

    //-------------------------------------------------
    public function scopeUpdatedBy( $query, $user_id ) {
        return $query->where( 'updated_by', $user_id );
    }

    //-------------------------------------------------
    public function scopeDeletedBy( $query, $user_id ) {
        return $query->where( 'deleted_by', $user_id );
    }

    //-------------------------------------------------
    public function scopeCreatedBetween( $query, $from, $to ) {
        return $query->whereBetween( 'created_at', array( $from, $to ) );
    }

    //-------------------------------------------------
    public function scopeUpdatedBetween( $query, $from, $to ) {
        return $query->whereBetween( 'updated_at', array( $from, $to ) );
    }

    //-------------------------------------------------
    public function scopeDeletedBetween( $query, $from, $to ) {
        return $query->whereBetween( 'deleted_at', array( $from, $to ) );
    }
    //-------------------------------------------------
    public function createdBy() {
        return $this->belongsTo( 'WebReinvent\VaahCms\Entities\User',
            'created_by', 'id'
        );
    }
    //-------------------------------------------------
    public function updatedBy() {
        return $this->belongsTo( 'WebReinvent\VaahCms\Entities\User',
            'updated_by', 'id'
        );
    }
    //-------------------------------------------------
    public function deletedBy() {
        return $this->belongsTo( 'WebReinvent\VaahCms\Entities\User',
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
            'name', 'slug', 'details',
            'count_users', 'count_permissions',
            'created_by', 'updated_by', 'deleted_by',
            'created_at', 'updated_at', 'deleted_at'
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

        switch($column)
        {
            //------------------------------------------------
            case 'id':
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
            //------------------------------------------------
            case 'created_at':
            case 'deleted_at':
            case 'updated_at':
            case 'count_users':
            case 'count_permissions':
                $result['editable'] = false;
                break;
            //------------------------------------------------
            case 'is_active':
                $result['type'] = 'select';
                $result['inputs'] = vh_is_active_options();
                break;
            //------------------------------------------------
            case 'details':
                $result['type'] = 'textarea';
                break;
            //------------------------------------------------

            //------------------------------------------------
            default:
                $result['type'] = 'text';
                break;
            //------------------------------------------------
        }

        return $result;
    }
    //-------------------------------------------------
    public static function store($request)
    {
        $rules = array(
            'name' => 'required'
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }

        $data = [];

        $inputs = $request->all();

        if($request->has('id'))
        {
            $item = Role::find($request->id);
        } else
        {
            $validation = static::roleValidation($request);
            if(isset($validation['status']) && $validation['status'] == 'failed')
            {
                return $validation;
            } else
            {
                $item = new Role();
                $item->is_active = 1;
            }
        }

        $item->fill($inputs);
        $item->save();

        //if new user is created
        if(!$request->has('id'))
        {
            Role::syncRolesWithUsers();
            Permission::syncPermissionsWithRoles();
            Role::recountRelations();
        }


        $response['status'] = 'success';
        $response['messages'][] = 'Saved';
        $response['data'] = $item;

        return $response;


    }
    //-------------------------------------------------
    public static function roleValidation($request)
    {

        //check if user already exist with the emails
        $role = Role::where('slug', Str::slug($request->name))->first();
        if($role)
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Record already exist.';
            return $response;
        }


    }
    //-------------------------------------------------
    public function recordForFormElement()
    {
        $record = $this->toArray();

        $columns = $this->getFormFillableColumns();

        $visible = ['id'];

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
            $reg = Role::find($id);
            $reg->is_active = $request->data;
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
            $item = Role::find($id);
            if($item)
            {
                $item->is_active = null;
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
            $item = Role::withTrashed()->where('id', $id)->first();
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
        $admin_role = Role::slug('admin')->first();
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
    //-------------------------------------------------
    //-------------------------------------------------


}
