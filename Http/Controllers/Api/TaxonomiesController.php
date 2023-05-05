<?php

namespace WebReinvent\VaahCms\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use WebReinvent\VaahCms\Models\Registration;
use WebReinvent\VaahCms\Models\Taxonomy;
use WebReinvent\VaahCms\Models\TaxonomyType;
use WebReinvent\VaahCms\Models\User;
use WebReinvent\VaahCms\Models\Role;

class TaxonomiesController extends Controller
{

    //----------------------------------------------------------
    public function __construct()
    {
    }
    //----------------------------------------------------------
    public function create(Request $request)
    {

        if($request->has('type') && $request->type){
            $type = TaxonomyType::where('slug',$request->type)->first();

            if(!$type){
                $response['success'] = false;
                $response['errors'][] = "Type not found.";
                return $response;
            }

            $request['type'] = $type->id;

            if($request->has('parent') && $request->parent){
                $parent = Taxonomy::where('slug',$request->parent)
                    ->where('type',$type->parent_id)->first();

                if(!$parent){
                    $response['success'] = false;
                    $response['errors'][] = "Parent not found.";
                    return $response;
                }

                $request['parent'] = $parent;

            }

        }

        $data = new \stdClass();
        $data->new_item = $request->all();
        $response = Taxonomy::createItem($data);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {
        $response = Taxonomy::getList($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $column, $value)
    {
        $item = Taxonomy::where($column, $value)->with(['createdByUser',
            'updatedByUser', 'deletedByUser']);

        if($request['trashed'] == 'true')
        {
            $item->withTrashed();
        }

        $item = $item->first();

        if (!$item) {
            $response['success'] = false;
            $response['errors'] = 'Taxonomy not found.';
            return $response;
        }

        $response['success'] = true;
        $response['data'] = $item;
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function update(Request $request, $column, $value)
    {

        $item = Taxonomy::where($column, $value)->first();

        if (!$item) {
            $response['success'] = false;
            $response['errors']  = 'Registration not found.';
            return $response;
        }

        $request['id'] = $item->id;

        if($request->has('type') && $request->type){
            $type = TaxonomyType::where('slug',$request->type)->first();

            if(!$type){
                $response['success'] = false;
                $response['errors'][] = "Type slug not found.";
                return $response;
            }

            $request['type'] = $type->id;

            if($request->has('parent') && $request->parent){
                $parent = Taxonomy::where('slug',$request->parent_slug)
                    ->where('type',$type->parent_id)->first();

                if(!$parent){
                    $response['success'] = false;
                    $response['errors'][] = "Parent slug not found.";
                    return $response;
                }

                $request['parent'] = $parent;

            }

        }


        $data = new \stdClass();
        $data->item = $request->all();

        $response = Taxonomy::postStore($data,$item->id);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function delete(Request $request, $column, $value)
    {

        $item = Taxonomy::where($column, $value)->first();

        if (!$item) {
            $response['success'] = false;
            $response['errors']  = 'Role not found.';
            return $response;
        }

        $request['inputs'] = [$item->id];

        $response = Taxonomy::bulkTrash($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
}
