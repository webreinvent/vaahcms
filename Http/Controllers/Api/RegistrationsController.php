<?php

namespace WebReinvent\VaahCms\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use WebReinvent\VaahCms\Models\Registration;
use WebReinvent\VaahCms\Models\Role;
use WebReinvent\VaahCms\Models\User;

class RegistrationsController extends Controller
{

    //----------------------------------------------------------
    public function __construct()
    {
    }
    //----------------------------------------------------------
    //----------------------------------------------------------
    public function create(Request $request)
    {
        $data = new \stdClass();
        $data->new_item = $request->all();
        $response = Registration::create($data);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {
        $response = Registration::getList($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $column, $value)
    {
        $item = Registration::where($column, $value)->with(['createdByUser',
            'updatedByUser', 'deletedByUser']);

        if($request['trashed'] == 'true')
        {
            $item->withTrashed();
        }

        $item = $item->first();

        if(!$item){
            $response['success'] = false;
            $response['errors']  = 'Registration not found.';
            return $response;
        }

        $response['success'] = true;
        $response['data'] = $item;
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function update(Request $request, $column, $value)
    {

        $item =  Registration::where($column, $value)
            ->withTrashed()->first();

        if(!$item){
            $response['success'] = false;
            $response['errors']  = 'Registration not found.';
            return $response;
        }

        $request['id'] = $item->id;

        $response = Registration::postStore($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function delete(Request $request, $column, $value)
    {

        $item = Registration::where($column, $value)->first();

        if(!$item){
            $response['success'] = false;
            $response['errors']  = 'Registration not found.';
            return $response;
        }

        $request['inputs'] = [$item->id];

        $response = Registration::bulkTrash($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function createUser(Request $request, $column, $value)
    {
        $item = Registration::withTrashed()->where($column, $value)->first();

        if (!$item) {
            $response['success'] = false;
            $response['errors']  = 'Registration not found.';
            return $response;
        }

        $response = Registration::createUser($item->id);
        return response()->json($response);
    }
}
