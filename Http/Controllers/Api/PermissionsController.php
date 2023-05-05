<?php

namespace WebReinvent\VaahCms\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use WebReinvent\VaahCms\Models\Registration;
use WebReinvent\VaahCms\Models\User;
use WebReinvent\VaahCms\Models\Permission;

class PermissionsController extends Controller
{

    //----------------------------------------------------------
    public function __construct()
    {
    }
    //----------------------------------------------------------
    //----------------------------------------------------------
    public function getList(Request $request)
    {
        $response = Permission::getList($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $column, $value)
    {
        $item = Permission::where($column, $value)->with(['createdByUser',
            'updatedByUser', 'deletedByUser']);

        if($request['trashed'] == 'true')
        {
            $item->withTrashed();
        }

        $item = $item->first();

        if(!$item){
            $response['success'] = false;
            $response['errors']  = 'Permission not found.';
            return $response;
        }

        $response['success'] = true;
        $response['data'] = $item;
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItemRoles(Request $request, $column, $value)
    {

        $item = Permission::withTrashed()->where($column, $value)->first();

        if(!$item){
            $response['success'] = false;
            $response['errors']  = 'Permission not found.';
            return $response;
        }

        $response['data']['permission'] = $item;


        $list = Role::whereHas('permissions', function($r) use($item,$request){
            $r->where('vh_role_permissions.is_active', 1);
            $r->where('vh_permissions.id',$item->id);
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

        $response['data']['roles'] = $list;
        $response['success'] = true;

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function getItemUsers(Request $request, $column, $value)
    {

        $item = Permission::withTrashed()->where($column, $value)->first();

        if(!$item){
            $response['success'] = false;
            $response['errors']  = 'Permission not found.';
            return $response;
        }

        $response['data']['permission'] = $item;


        $role_ids = $item->roles()->where('vh_role_permissions.is_active', 1)->pluck('vh_roles.id');

        $list = User::whereHas('roles', function($r) use($role_ids,$request){
            $r->where('vh_user_roles.is_active', 1);
            $r->whereIn('vh_roles.id',$role_ids);
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
        $response['success'] = true;

        return response()->json($response);
    }


}
