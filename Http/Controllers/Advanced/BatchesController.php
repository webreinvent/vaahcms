<?php namespace WebReinvent\VaahCms\Http\Controllers\Advanced;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\Batch;


class BatchesController extends Controller
{


    //----------------------------------------------------------
    public function __construct()
    {

    }

    //----------------------------------------------------------

    public function getAssets(Request $request)
    {

        if(!\Auth::user()->hasPermission('has-access-of-advanced-section'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $data = [];
        $data['permission'] = [];

        $response['success'] = true;
        $response['data'] = $data;

        return response()->json($response);
    }
    //----------------------------------------------------------
    //----------------------------------------------------------
    public function getList(Request $request)
    {
        if(!\Auth::user()->hasPermission('has-access-of-advanced-section'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $response = Batch::getList($request);
        return response()->json($response);
    }
    //----------------------------------------------------------

    //----------------------------------------------------------
    //----------------------------------------------------------
    public function postActions(Request $request, $action)
    {

        if(!\Auth::user()->hasPermission('has-access-of-advanced-section'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $response = [];

        $response['success'] = true;

        switch ($action)
        {

            //------------------------------------
            case 'bulk-delete':

                $response = Batch::bulkDelete($request);

                break;
            //------------------------------------
            case 'bulk-delete-all':

                $response = Batch::bulkDeleteAll($request);

                break;
            //------------------------------------
            //------------------------------------
            //------------------------------------

        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
