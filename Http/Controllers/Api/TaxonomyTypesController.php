<?php

namespace WebReinvent\VaahCms\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use WebReinvent\VaahCms\Models\Registration;
use WebReinvent\VaahCms\Models\Taxonomy;
use WebReinvent\VaahCms\Models\TaxonomyType;
use WebReinvent\VaahCms\Models\User;
use WebReinvent\VaahCms\Models\Role;

class TaxonomyTypesController extends Controller
{

    //----------------------------------------------------------
    public function __construct()
    {
    }
    //----------------------------------------------------------
    public function create(Request $request)
    {

        if($request->has('parent') && $request->parent){
            $parent = TaxonomyType::where('slug',$request->parent)->first();

            if(!$parent){
                $response['success'] = false;
                $response['errors'][] = "Parent slug not found.";
                return $response;
            }

            $request['parent_id'] = $parent->id;

        }

        $data = new \stdClass();
        $data->new_item = $request->all();
        $response = TaxonomyType::createItem($data);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {
        $response = TaxonomyType::getList($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $column, $value)
    {
        $item = TaxonomyType::where($column, $value)->with(['createdByUser',
            'updatedByUser', 'deletedByUser']);

        if($request->has('with_parent') && $request->with_parent){
            $item->with(['parent']);
        }

        if($request->has('with_children') && $request->with_children){
            $item->with(['childrens'])->whereNull('parent_id');
        }

        if($request['trashed'] == 'true')
        {
            $item->withTrashed();
        }

        $item = $item->first();

        if(!$item){
            $response['success'] = false;
            $response['errors']  = 'Taxonomy\'s Type not found.';
            return $response;
        }

        $response['success'] = true;
        $response['data'] = $item;
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function update(Request $request, $column, $value)
    {

        $item = TaxonomyType::where($column, $value)->first();

        if (!$item) {
            $response['success'] = false;
            $response['errors'] = 'Taxonomy\'s Type not found.';
            return $response;
        }

        if($request->has('parent') && $request->parent){
            $parent = TaxonomyType::where('slug',$request->parent)->first();

            if(!$parent){
                $response['success'] = false;
                $response['errors'][] = "Parent slug not found.";
                return $response;
            }

            $request['parent_id'] = $parent->id;

        }

        $request['id'] = $item->id;

        $data = new \stdClass();
        $data->item = $request->all();

        $response = TaxonomyType::postStore($data,$item->id);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function delete(Request $request, $column, $value)
    {

        $item = TaxonomyType::where($column, $value)->first();

        if (!$item) {
            $response['success'] = false;
            $response['errors']  = 'Taxonomy\'s Type not found.';
            return $response;
        }

        $request['inputs'] = [$item->id];

        $response = TaxonomyType::bulkTrash($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
}
