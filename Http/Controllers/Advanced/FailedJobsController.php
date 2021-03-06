<?php namespace WebReinvent\VaahCms\Http\Controllers\Advanced;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\FailedJob;
use WebReinvent\VaahCms\Entities\Job;


class FailedJobsController extends Controller
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
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $data = [];
        $data['permission'] = [];

        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);
    }
    //----------------------------------------------------------

    //----------------------------------------------------------
    public function getList(Request $request)
    {

        if(!\Auth::user()->hasPermission('has-access-of-advanced-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $response = FailedJob::getList($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postActions(Request $request, $action)
    {

        if(!\Auth::user()->hasPermission('has-access-of-advanced-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $response = [];

        $response['status'] = 'success';

        switch ($action)
        {

            //------------------------------------
            case 'bulk-delete':

                $response = FailedJob::bulkDelete($request);

                break;
            //------------------------------------
            case 'bulk-delete-all':

                $response = FailedJob::bulkDeleteAll($request);

                break;
            //------------------------------------
            //------------------------------------

        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
