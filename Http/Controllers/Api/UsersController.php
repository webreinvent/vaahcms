<?php

namespace WebReinvent\VaahCms\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use WebReinvent\VaahCms\Models\Registration;
use WebReinvent\VaahCms\Models\Permission;
use WebReinvent\VaahCms\Models\User;

class UsersController extends Controller
{

    //----------------------------------------------------------
    public function __construct()
    {
    }
    //----------------------------------------------------------
    public function create(Request $request)
    {
        $response = User::create($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {
        $response = User::getList($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $column, $value)
    {
        $item = User::where($column, $value)->with(['createdByUser',
            'updatedByUser', 'deletedByUser']);

        if($request['trashed'] == 'true')
        {
            $item->withTrashed();
        }

        $item = $item->first();

        if (!$item) {
            $response['success'] = false;
            $response['errors']  = 'User not found.';
            return $response;
        }

        $response['success'] = true;
        $response['data'] = $item;
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function update(Request $request, $column, $value)
    {

        $item = User::where($column, $value)->first();

        if (!$item) {
            $response['success'] = false;
            $response['errors']  = 'Registration not found.';
            return $response;
        }

        $request['id'] = $item->id;

        $response = User::postStore($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function delete(Request $request, $column, $value)
    {

        $item = User::where($column, $value)->first();

        if (!$item) {
            $response['success'] = false;
            $response['errors']  = 'User not found.';
            return $response;
        }

        $request['inputs'] = [$item->id];
        $request['action'] = 'bulk-change-status';

        $response = User::bulkTrash($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItemRoles(Request $request, $column, $value, $role_slug = null)
    {

        $item = User::withTrashed()->where($column, $value)->first();

        if (!$item) {
            $response['success'] = false;
            $response['errors']  = 'User not found.';
            return $response;
        }

        if ($role_slug) {
            $response['success'] = true;
            $response['data'] = false;

            if($item->hasRole($role_slug)){
                $response['data'] = true;
            }

            return response()->json($response);
        }

        $response['data']['user'] = $item;


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

        if(isset($request['per_page'])
            && $request['per_page']
            && is_numeric($request['per_page'])){
            $list = $list->paginate($request['per_page']);
        }else{
            $list = $list->paginate(config('vaahcms.per_page'));
        }

        foreach ($list as $role){

            $data = User::getPivotData($role->pivot);

            $role['json'] = $data;
            $role['json_length'] = count($data);
        }

        $response['data']['roles'] = $list;
        $response['success'] = true;

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function getItemPermissions(Request $request,
                                       $column, $value,
                                       $permission_slug = null)
    {

        $item = User::withTrashed()->where($column, $value)->first();

        if (!$item) {
            $response['success'] = false;
            $response['errors']  = 'User not found.';
            return $response;
        }

        if($permission_slug){

            $response['success'] = true;
            $response['data'] = false;

            if($item->hasPermission($permission_slug)){
                $response['data'] = true;
            }

            return response()->json($response);
        }

        $response['data']['user'] = $item;

        $role_ids = $item->roles()->where('vh_user_roles.is_active', 1)->pluck('vh_roles.id');

        $list = Permission::whereHas('roles', function($r) use($role_ids,$request){
            $r->where('vh_role_permissions.is_active', 1);
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

        $response['data']['permissions'] = $list;
        $response['success'] = true;

        return response()->json($response);
    }


}
