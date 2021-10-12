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

class UsersController extends Controller
{

    //----------------------------------------------------------
    public function __construct()
    {
    }
    //----------------------------------------------------------
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
            'updatedByUser', 'deletedByUser'])
            ->withTrashed()->first();

        if(!$item){
            $response['status']     = 'failed';
            $response['errors']     = 'User not found.';
            return $response;
        }

        $response['status'] = 'success';
        $response['data'] = $item;
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItemRoles(Request $request, $column, $value)
    {

        $item = User::withTrashed()->where($column, $value)->first();

        if(!$item){
            $response['status']     = 'failed';
            $response['errors']     = 'User not found.';
            return $response;
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
        $response['status'] = 'success';

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function getItemPermissions(Request $request, $column, $value)
    {

        $item = User::withTrashed()->where($column, $value)->first();

        if(!$item){
            $response['status']     = 'failed';
            $response['errors']     = 'User not found.';
            return $response;
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
        $response['status'] = 'success';

        return response()->json($response);
    }


}
