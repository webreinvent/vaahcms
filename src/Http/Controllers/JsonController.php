<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use VaahCms\Modules\Cms\Entities\MenuItem;
use VaahCms\Modules\Cms\Entities\Page;

class JsonController extends Controller
{



    //----------------------------------------------------------
    public function __construct()
    {

    }

    //----------------------------------------------------------
    public function getPublicAssets(Request $request)
    {

        $data['vaahcms'] = [
            'name' => config('vaahcms.app_name'),
            'slug' => config('vaahcms.app_slug'),
            'version' => config('vaahcms.version'),
        ];

        if($request->has('get_server_details'))
        {
            $data['server'] = [
                'host' => $request->getHost(),
                'current_year' => \Carbon::now()->format('Y'),
                'current_date' => \Carbon::now()->format('Y-m-d'),
                'current_time' => \Carbon::now()->format('H:i:s'),
                'current_date_time' => \Carbon::now()->format('Y-m-d H:i:s'),
                'http' => 'http://',
            ];

            if(\Request::secure())
            {
                $data['server']['http'] = 'https://';
            }




        }

        //-----Vue Errors----------------------
        $data['vue_errors'] = null;
        $vue_errors = session()->get('vue_errors');
        if(isset($vue_errors) && count($vue_errors) > 0)
        {
            $data['vue_errors'] = $vue_errors;
        }
        \Session::forget('vue_errors');
        //-----Vue Errors----------------------


        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);


    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
