<?php

namespace WebReinvent\VaahCms\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use WebReinvent\VaahCms\Entities\Registration;
use WebReinvent\VaahCms\Entities\Role;
use WebReinvent\VaahCms\Entities\Taxonomy;
use WebReinvent\VaahCms\Entities\User;

class TaxonomiesController extends Controller
{

    //----------------------------------------------------------
    public function __construct()
    {
    }
    //----------------------------------------------------------
    public function create(Request $request)
    {
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
            'updatedByUser', 'deletedByUser'])
            ->withTrashed()->first();

        if(!$item){
            $response['status']     = 'failed';
            $response['errors']     = 'Taxonomy not found.';
            return $response;
        }

        $response['status'] = 'success';
        $response['data'] = $item;
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function update(Request $request, $column, $value)
    {

        $item = Taxonomy::where($column, $value)->first();

        if(!$item){
            $response['status']     = 'failed';
            $response['errors']     = 'Registration not found.';
            return $response;
        }


        $data = new \stdClass();
        $data->item = $request->all();

        $response = Taxonomy::postStore($data,$item->id);
        return response()->json($response);
    }
    //----------------------------------------------------------
}
