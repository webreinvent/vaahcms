<?php namespace WebReinvent\VaahCms\Http\Controllers\Backend\Advanced;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Models\Batch;

class BatchesController extends Controller
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

        $model = new Batch();
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
        $response = Batch::getList($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function updateList(Request $request)
    {
        return Batch::updateList($request);
    }
    //----------------------------------------------------------
    public function listAction(Request $request, $type)
    {
        return Batch::listAction($request, $type);
    }
    //----------------------------------------------------------
    public function deleteList(Request $request)
    {
        return Batch::deleteList($request);
    }
    //----------------------------------------------------------
    public function createItem(Request $request)
    {
        return Batch::createItem($request);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $id)
    {
        return Batch::getItem($id);
    }
    //----------------------------------------------------------
    public function updateItem(Request $request,$id)
    {
        return Batch::updateItem($request,$id);
    }
    //----------------------------------------------------------
    public function deleteItem(Request $request,$id)
    {
        $request->merge(['inputs' =>[$id]]);

        return Batch::bulkDelete($request);
    }
    //----------------------------------------------------------
    public function itemAction(Request $request,$id,$action)
    {
        return Batch::itemAction($request,$id,$action);
    }
    //----------------------------------------------------------


}
