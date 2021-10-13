<?php

namespace WebReinvent\VaahCms\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use WebReinvent\VaahCms\Entities\Permission;
use WebReinvent\VaahCms\Entities\Registration;
use WebReinvent\VaahCms\Entities\Role;
use WebReinvent\VaahCms\Entities\User;

class RolesController extends Controller
{

    //----------------------------------------------------------
    public function __construct()
    {
    }
    //----------------------------------------------------------
    public function create(Request $request)
    {
        $data = new \stdClass();
        $data->new_item = $request->all();
        $response = Role::create($data);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {
        $response = Role::getList($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function update(Request $request, $column, $value)
    {

        $item = Role::where($column, $value)->first();

        if(!$item){
            $response['status']     = 'failed';
            $response['errors']     = 'Role not found.';
            return $response;
        }

        $request['id'] = $item->id;

        $data = new \stdClass();
        $data->item = $request->all();

        $response = Role::postStore($data,$item->id);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function delete(Request $request, $column, $value)
    {

        $item = Role::where($column, $value)->first();

        if(!$item){
            $response['status']     = 'failed';
            $response['errors']     = 'Role not found.';
            return $response;
        }

        $request['inputs'] = [$item->id];

        $response = Role::bulkTrash($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $column, $value)
    {
        $item = Role::where($column, $value)->with(['createdByUser',
            'updatedByUser', 'deletedByUser'])
            ->withTrashed()->first();

        if(!$item){
            $response['status']     = 'failed';
            $response['errors']     = 'Role not found.';
            return $response;
        }

        $response['status'] = 'success';
        $response['data'] = $item;
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItemUsers(Request $request, $column, $value)
    {

        $item = Role::withTrashed()->where($column, $value)->first();

        if(!$item){
            $response['status']     = 'failed';
            $response['errors']     = 'Role not found.';
            return $response;
        }

        $response['data']['role'] = $item;

        $list = User::whereHas('roles', function($r) use($item,$request){
            $r->where('vh_user_roles.is_active', 1);
            $r->where('vh_roles.id',$item->id);
        });

        if($request->has("q"))
        {
            $list->where(function ($q) use ($request){
                $q->where('name', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('slug', 'LIKE', '%'.$request->q.'%');
            });
        }

        if(isset($request['per_page'])
            && $request['per_page']
            && is_numeric($request['per_page'])){
            $list = $list->paginate($request['per_page']);
        }else{
            $list = $list->paginate(config('vaahcms.per_page'));
        }

        $response['data']['users'] = $list;
        $response['status'] = 'success';

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function getItemPermissions(Request $request, $column, $value)
    {

        $item = Role::withTrashed()->where($column, $value)->first();

        if(!$item){
            $response['status']     = 'failed';
            $response['errors']     = 'Role not found.';
            return $response;
        }

        $response['data']['role'] = $item;

        $list = Permission::whereHas('roles', function($r) use($item,$request){
            $r->where('vh_role_permissions.is_active', 1);
            $r->where('vh_roles.id',$item->id);
        });

        if($request->has("q"))
        {
            $list->where(function ($q) use ($request){
                $q->where('name', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('slug', 'LIKE', '%'.$request->q.'%');
            });
        }

        if(isset($request['per_page'])
            && $request['per_page']
            && is_numeric($request['per_page'])){
            $list = $list->paginate($request['per_page']);
        }else{
            $list = $list->paginate(config('vaahcms.per_page'));
        }

        $response['data']['permissions'] = $list;
        $response['status'] = 'success';

        return response()->json($response);
    }


}
