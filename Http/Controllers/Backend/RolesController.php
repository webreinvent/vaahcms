<?php namespace WebReinvent\VaahCms\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\Permission;
use WebReinvent\VaahCms\Models\Role;


class RolesController extends Controller
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

        $model = new Role();
        $fillable = $model->getFillable();
        $data['fillable']['columns'] = array_diff(
            $fillable, $data['fillable']['except']
        );

        foreach ($fillable as $column)
        {
            $data['empty_item'][$column] = null;
        }

        $modules = Permission::withTrashed()->get()->unique('module')->pluck('module');

        $data['actions'] = [];
        $data['modules'] = $modules;

        $response['success'] = true;
        $response['data'] = $data;

        return $response;
    }

    //----------------------------------------------------------
    public function getList(Request $request)
    {
        return Role::getList($request);
    }
    //----------------------------------------------------------
    public function updateList(Request $request)
    {
        return Role::updateList($request);
    }
    //----------------------------------------------------------
    public function listAction(Request $request, $type)
    {
        return Role::listAction($request, $type);
    }
    //----------------------------------------------------------
    public function deleteList(Request $request)
    {
        return Role::deleteList($request);
    }
    //----------------------------------------------------------
    public function createItem(Request $request)
    {
        return Role::createItem($request);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $id)
    {
        return Role::getItem($id);
    }
    //----------------------------------------------------------
    public function updateItem(Request $request,$id)
    {
        return Role::updateItem($request,$id);
    }
    //----------------------------------------------------------
    public function deleteItem(Request $request,$id)
    {
        return Role::deleteItem($request,$id);
    }
    //----------------------------------------------------------
    public function itemAction(Request $request,$id,$action)
    {
        return Role::itemAction($request,$id,$action);
    }
    //----------------------------------------------------------
    public function getItemPermission(Request $request, $id)
    {
        return Role::getItemPermission($request, $id);
    }
    //----------------------------------------------------------
    public function getItemUser(Request $request, $id)
    {
        return Role::getItemUser($request, $id);
    }
    //----------------------------------------------------------
    public function postActions(Request $request, $action)
    {
        return Role::postActions($request, $action);
    }
    //----------------------------------------------------------
    public function getModuleSections(Request $request)
    {
        return  Role::getModuleSections($request);
    }
    //----------------------------------------------------------


}
