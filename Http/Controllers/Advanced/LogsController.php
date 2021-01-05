<?php

namespace WebReinvent\VaahCms\Http\Controllers\Advanced;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use WebReinvent\VaahLaravel\Libraries\VaahFiles;

class LogsController extends Controller
{


    //----------------------------------------------------------
    public function __construct()
    {



    }

    //----------------------------------------------------------
    public function getList(Request $request)
    {

        $permission_slug = 'has-access-of-logs-section';

        if(!\Auth::user()->hasPermission($permission_slug))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");
            if(env('APP_DEBUG'))
            {
                $response['hint'][] = 'Permission slug: '.$permission_slug;
            }
            return response()->json($response);
        }

        $folder_path = storage_path('logs');

        $files = VaahFiles::getAllFiles($folder_path);
        $list = [];
        $i = 1;

        if(count($files) > 0)
        {
            foreach ($files as $file)
            {

                if(isset($request->q) && $request->q){
                    if(stripos($file,$request->q) !== FALSE){
                        $list[] = [
                            'id' => $i,
                            'name' => $file,
                            'path' => $folder_path.'\\'.$file,
                        ];
                    }
                }else{

                    $list[] = [
                        'id' => $i,
                        'name' => $file,
                        'path' => $folder_path.'\\'.$file,
                    ];

                }

                $i++;
            }
        }



        $response['status'] = 'success';
        $response['data']['list'] = $list;

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function getItem(Request $request, $name)
    {

        $permission_slug = 'has-access-of-logs-section';

        if(!\Auth::user()->hasPermission($permission_slug))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");
            if(env('APP_DEBUG'))
            {
                $response['hint'][] = 'Permission slug: '.$permission_slug;
            }
            return response()->json($response);
        }


        $response['status'] = 'success';
        $response['data'] = [];

        $path = storage_path('logs/'.$name);

        $response['data']['name'] = $name;
        $response['data']['path'] = $path;

        if(File::exists($path))
        {


            $content = File::get($path);

            $pattern = "/^\[(?<date>.*)\]\s(?<env>\w+)\.(?<type>\w+):(?<message>.*)/m";

            preg_match_all($pattern, $content, $matches, PREG_SET_ORDER, 0);


            $logs = [];
            foreach ($matches as $match) {
                $logs[] = [
                    'timestamp' => \Carbon::parse($match['date'])->format('Y-m-d h:i A'),
                    'ago' => \Carbon::parse($match['date'])->diffForHumans(),
                    'env' => $match['env'],
                    'type' => $match['type'],
                    'message' => trim($match['message'])
                ];
            }

            $response['data']['content'] = $content;
            $response['data']['logs'] = $logs;


        }


        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postActions(Request $request, $action)
    {
        $response = [];

        $folder_path = storage_path('logs');

        switch ($action)
        {
            //------------------------------------
            case 'bulk-delete':

                $response = VaahFiles::deleteFolder($folder_path);

                break;
            //------------------------------------

        }

        return response()->json($response);

    }
    //----------------------------------------------------------

    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------


}
