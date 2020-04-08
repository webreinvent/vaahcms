<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\Permission;
use WebReinvent\VaahCms\Entities\Role;

class RolesController extends Controller
{

    public $theme;

    //----------------------------------------------------------
    public function __construct()
    {
        $this->theme = vh_get_backend_theme();
    }

    //----------------------------------------------------------
    public function index()
    {
        return view($this->theme.'.pages.roles');
    }

    public function getAssets(Request $request)
{
    $module = Permission::getModuleList();

    $data['country_calling_code'] = vh_get_country_list();
    $data['country'] = vh_get_country_list();
    $data['country_code'] = vh_get_country_list();
    $data['registration_statuses'] = vh_registration_statuses();
    $data['bulk_actions'] = vh_general_bulk_actions();
    $data['name_titles'] = vh_name_titles();
    $data['module'] = $module;

    $response['status'] = 'success';
    $response['data'] = $data;

    return response()->json($response);
}
    //----------------------------------------------------------
    public function assets(Request $request)
    {

        $model = new Role();
        $data['columns'] = $model->getFormColumns(true);
        $data['debug'] = config('vaahcms.debug');

        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function store(Request $request)
    {
        $response = Role::store($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $id)
    {

        $response = Role::getDetail($id);
        return response()->json($response);

    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {

        if($request->has('recount') && $request->get('recount') == true)
        {
            Permission::syncPermissionsWithRoles();
            Role::syncRolesWithUsers();
            Role::recountRelations();
        }

        if($request->has("sort_by") && !is_null($request->sort_by))
        {

            if($request->sort_by == 'deleted_at')
            {
                $list = Role::onlyTrashed();
            } else
            {
                $list = Role::orderBy($request->sort_by, $request->sort_type);
            }

        } else
        {
            $list = Role::orderBy('created_at', 'DESC');
        }

        if($request->has("q"))
        {
            $list->where(function ($q) use ($request){
                $q->where('name', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('slug', 'LIKE', '%'.$request->q.'%');
            });
        }

        $data['list'] = $list->paginate(config('vaahcms.per_page'));

        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function actions(Request $request)
    {
        $rules = array(
            'action' => 'required',
            'inputs' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $response['status'] = 'success';
        $response['messages'][] = 'Action was successful';

        $inputs = $request->all();

        switch ($request->action)
        {

            //------------------------------------
            case 'bulk_change_status':

                $response = Role::bulkStatusChange($request);

                break;
            //------------------------------------
            case 'bulk_delete':

                $response = Role::bulkDelete($request);

                break;
            //------------------------------------
            case 'bulk_restore':

                $response = Role::bulkRestore($request);

                break;

            //------------------------------------
            case 'delete':


                if($response['status'] == 'success')
                {
                    $item = Role::find($inputs['inputs']['id']);
                    $item->is_active = 0;
                    $item->save();

                    $item->delete();

                    $response['messages'] = [];
                }

                break;
            //------------------------------------
            case 'change_active_status':

                if($response['status'] == 'success')
                {
                    $item = Role::find($inputs['inputs']['id']);
                    $item->is_active = $inputs['data']['is_active'];
                    $item->save();
                    $response['messages'] = [];
                }

                break;
            //------------------------------------
            case 'toggle_permission_active_status':

                if($response['status'] == 'success')
                {
                    $item = Role::find($inputs['inputs']['id']);

                    if($item->id == 1)
                    {
                        $response['status'] = 'failed';
                        $response['errors'][] = 'Admin permission can not be changed';
                        return response()->json($response);

                    }

                    $item->permissions()->updateExistingPivot($inputs['inputs']['permission_id'], array('is_active' => $inputs['data']['is_active']));
                    Role::recountRelations();
                    $response['messages'] = [];
                }

                break;
            //------------------------------------
            case 'toggle_user_active_status':

                if($response['status'] == 'success')
                {
                    $item = Role::find($inputs['inputs']['id']);
                    $item->users()->updateExistingPivot($inputs['inputs']['user_id'], array('is_active' => $inputs['data']['is_active']));
                    Role::recountRelations();
                    $response['messages'] = [];
                }

                break;
            //------------------------------------
            //------------------------------------

        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function getPermissions(Request $request, $id)
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

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getUsers(Request $request, $id)
    {
        $item = Role::withTrashed()->where('id', $id)->first();
        $response['data']['item'] = $item;

        if($request->has("q"))
        {
            $list = $item->users()->where(function ($q) use ($request){
                $q->where('name', 'LIKE', '%'.$request->q.'%')
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

        return response()->json($response);
    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
