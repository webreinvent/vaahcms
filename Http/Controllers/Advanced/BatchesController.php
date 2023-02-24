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
        
        try{

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

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    //----------------------------------------------------------
    public function getList(Request $request)
    {

        try{

            if(!\Auth::user()->hasPermission('has-access-of-advanced-section'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }

            $response = Batch::getList($request);

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------

    //----------------------------------------------------------
    //----------------------------------------------------------
    public function postActions(Request $request, $action)
    {

        try{

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

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
