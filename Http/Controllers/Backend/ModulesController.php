<?php namespace WebReinvent\VaahCms\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Models\Module;


class ModulesController extends Controller
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

        $model = new Module();
        $fillable = $model->getFillable();
        $data['fillable']['columns'] = array_diff(
            $fillable, $data['fillable']['except']
        );

        foreach ($fillable as $column)
        {
            $data['empty_item'][$column] = null;
        }

        $data['actions'] = [];

        $response['success'] = true;
        $response['data'] = $data;

        return $response;
    }

    //----------------------------------------------------------
    public function getList(Request $request)
    {
        return Module::getList($request);
    }
    //----------------------------------------------------------
    public function updateList(Request $request)
    {
        return Module::updateList($request);
    }
    //----------------------------------------------------------
    public function listAction(Request $request, $type)
    {
        return Module::listAction($request, $type);
    }
    //----------------------------------------------------------
    public function deleteList(Request $request)
    {
        return Module::deleteList($request);
    }
    //----------------------------------------------------------
    public function createItem(Request $request)
    {
        return Module::createItem($request);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $id)
    {
        return Module::getItem($id);
    }
    //----------------------------------------------------------
    public function updateItem(Request $request,$id)
    {
        return Module::updateItem($request,$id);
    }
    //----------------------------------------------------------
    public function deleteItem(Request $request,$id)
    {
        return Module::deleteItem($request,$id);
    }
    //----------------------------------------------------------
    public function itemAction(Request $request,$id,$action)
    {
        return Module::itemAction($request,$id,$action);
    }
    //----------------------------------------------------------


}
