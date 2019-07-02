<?php

namespace WebReinvent\VaahCms\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\Permission;
use WebReinvent\VaahCms\Entities\Role;

class PermissionController extends Controller
{

    public $theme;

    //----------------------------------------------------------
    public function __construct()
    {
        $this->theme = vh_get_admin_theme();
    }

    //----------------------------------------------------------
    public function index()
    {
        return view($this->theme.'.pages.permissions');
    }
    //----------------------------------------------------------
    public function assets(Request $request)
    {

        $model = new Permission();
        $data['columns'] = $model->getFormColumns(true);
        $data['debug'] = config('vaahcms.debug');

        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function store(Request $request)
    {
        $response = Permission::store($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getDetails(Request $request, $id)
    {

        $item = Permission::where('id', $id)->withTrashed()->first();

        $response['status'] = 'success';
        $response['data'] = $item->recordForFormElement();

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {

        if($request->has('recount') && $request->get('recount') == true)
        {
            Permission::syncPermissionsWithRoles();
            Permission::recountRelations();
        }

        if($request->has("sort_by") && !is_null($request->sort_by))
        {

            if($request->sort_by == 'deleted_at')
            {
                $list = Permission::onlyTrashed();
            } else
            {
                $list = Permission::orderBy($request->sort_by, $request->sort_type);
            }

        } else
        {
            $list = Permission::orderBy('created_at', 'DESC');
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

                $response = Permission::bulkStatusChange($request);

                break;
            //------------------------------------
            case 'bulk_delete':

                $response = Permission::bulkDelete($request);

                break;
            //------------------------------------
            case 'bulk_restore':

                $response = Permission::bulkRestore($request);

                break;

            //------------------------------------
            case 'delete':


                if($response['status'] == 'success')
                {
                    $item = Permission::find($inputs['inputs']['id']);
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
                    $item = Permission::find($inputs['inputs']['id']);
                    $item->is_active = $inputs['data']['is_active'];
                    $item->save();
                    $response['messages'] = [];
                }

                break;
            //------------------------------------
            case 'toggle_role_active_status':

                if($response['status'] == 'success')
                {
                    $item = Permission::find($inputs['inputs']['id']);
                    $item->roles()->updateExistingPivot($inputs['inputs']['role_id'], array('is_active' => $inputs['data']['is_active']));
                    Permission::recountRelations();
                    $response['messages'] = [];
                }

                break;
            //------------------------------------

        }

        return response()->json($response);

    }
    //----------------------------------------------------------

    public function getRoles(Request $request, $id)
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
        $list = $list->paginate(1);

        $response['data']['list'] = $list;

        $response['status'] = 'success';

        return response()->json($response);
    }

    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------


}
