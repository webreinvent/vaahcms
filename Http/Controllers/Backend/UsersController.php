<?php
namespace WebReinvent\VaahCms\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Models\Role;
use WebReinvent\VaahCms\Models\User;


class UsersController extends Controller
{


    //----------------------------------------------------------
    public function __construct()
    {

    }

    //----------------------------------------------------------

    public function getAssets(Request $request)
    {

        $data = [];

        $data['permission'] = [];
        $data['rows'] = config('vaahcms.per_page');

        $data['fillable']['except'] = [
            'uuid',
            'created_by',
            'updated_by',
            'deleted_by',
        ];

        $model = new User();
        $fillable = $model->getFillable();
        $data['fillable']['columns'] = array_diff(
            $fillable, $data['fillable']['except']
        );

        foreach ($fillable as $column)
        {
            $data['empty_item'][$column] = null;
        }

        $countRole = Role::all()->count();

        $data['actions'] = [];
        $data['name_titles'] = vh_name_titles();
        $data['countries'] = vh_get_country_list();
        $data['timezones'] = vh_get_timezones();
        $data['totalRole'] = $countRole;
        $response['success'] = true;
        $response['data'] = $data;

        return $response;
    }

    //----------------------------------------------------------
    public function getList(Request $request)
    {
        $response = User::getList($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function updateList(Request $request)
    {
        return User::updateList($request);
    }
    //----------------------------------------------------------
    public function listAction(Request $request, $type)
    {
        return User::listAction($request, $type);
    }
    //----------------------------------------------------------
    public function deleteList(Request $request)
    {
        return User::deleteList($request);
    }
    //----------------------------------------------------------
    public function createItem(Request $request)
    {
       return User::createItem($request);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $id)
    {
        return User::getItem($id);
    }
    //----------------------------------------------------------
    public function updateItem(Request $request,$id)
    {
        if (!\Auth::user()->hasPermission('can-update-users')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

        dd(1);

        $item = User::where('id',$id)->first();

        if(!$item){
            $response['status']     = 'failed';
            $response['errors']     = 'Registration not found.';
            return $response;
        }

        $request['id'] = $item->id;

        return User::updateItem($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function deleteItem(Request $request,$id)
    {
        return User::deleteItem($request,$id);
    }
    //----------------------------------------------------------
    public function itemAction(Request $request,$id,$action)
    {
        return User::itemAction($request,$id,$action);
    }
    //----------------------------------------------------------
    public function getItemRoles(Request $request,$id){

        $item = User::withTrashed()->where('id', $id)->first();

        $response['data']['item'] = $item;


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

            $data = User::getPivotData($role->pivot);

            $role['json'] = $data;
            $role['json_length'] = count($data);
        }

        $response['data']['list'] = $list;
        $response['status'] = 'success';

        return response()->json($response);

    }

    public function postActions(Request $request, $action){

        $rules = array(
            'inputs' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $response = [];

        $request->merge(['action'=>$action]);

        switch ($action)
        {

            //------------------------------------
            case 'bulk-change-status':

                if(!\Auth::user()->hasPermission('can-manage-users') &&
                    !\Auth::user()->hasPermission('can-update-users'))
                {
                    $response['status'] = 'failed';
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return $response;
                }

                $response = User::bulkStatusChange($request);

                break;
            //------------------------------------
            case 'bulk-trash':

                if(!\Auth::user()->hasPermission('can-update-users'))
                {
                    $response['status'] = 'failed';
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return $response;
                }

                $response = User::bulkTrash($request);

                break;
            //------------------------------------
            case 'bulk-restore':

                if(!\Auth::user()->hasPermission('can-update-users'))
                {
                    $response['status'] = 'failed';
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return $response;
                }

                $response = User::bulkRestore($request);

                break;

            //------------------------------------
            case 'bulk-delete':

                if(!\Auth::user()->hasPermission('can-update-users') ||
                    !\Auth::user()->hasPermission('can-delete-users'))
                {
                    $response['status'] = 'failed';
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return $response;
                }

                $response = User::bulkDelete($request);

                break;
            //------------------------------------
            case 'toggle-role-active-status':

                if(!\Auth::user()->hasPermission('can-manage-users') &&
                    !\Auth::user()->hasPermission('can-update-users'))
                {
                    $response['status'] = 'failed';
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return $response;
                }

                $response = User::bulkChangeRoleStatus($request);

                break;
            //------------------------------------

        }

        return response()->json($response);
    }


}
