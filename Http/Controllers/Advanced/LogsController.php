<?php

namespace WebReinvent\VaahCms\Http\Controllers\Advanced;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use WebReinvent\VaahExtend\Libraries\VaahFiles;

class LogsController extends Controller
{


    //----------------------------------------------------------
    public function __construct()
    {



    }

    //----------------------------------------------------------
    public function getList(Request $request)
    {

        if(!\Auth::user()->hasPermission('has-access-of-advanced-section'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $folder_path = storage_path('logs');

        $folder_path = str_replace("\\", "/", $folder_path);

        $list = [];

        if(File::isDirectory($folder_path)){
            $files = VaahFiles::getAllFiles($folder_path);
            $i = 1;

            if(count($files) > 0)
            {
                foreach ($files as $file) {

                    if ($request->has('file_type') && $request->file_type
                        && count($request->file_type) > 0 ) {

                        $file_name_array = explode(".", $file);

                        if (count($file_name_array) > 1
                            && in_array('.'.$file_name_array[1], $request->file_type) ) {

                            if ($request->has('q') && $request->q) {
                                if (stripos($file, $request->q) !== FALSE) {
                                    $list[] = [
                                        'id' => $i,
                                        'name' => $file,
                                        'path' => $folder_path . '/' . $file,
                                    ];
                                }
                            } else {
                                $list[] = [
                                    'id' => $i,
                                    'name' => $file,
                                    'path' => $folder_path . '/' . $file,
                                ];
                            }

                            $i++;


                        }
                    } elseif ($request->has('q') && $request->q) {
                        if (stripos($file, $request->q) === FALSE) {
                            continue;
                        }
                        $list[] = [
                            'id' => $i,
                            'name' => $file,
                            'path' => $folder_path . '/' . $file,
                        ];

                        $i++;
                    } else {

                        $list[] = [
                            'id' => $i,
                            'name' => $file,
                            'path' => $folder_path . '/' . $file,
                        ];

                        $i++;

                    }


                }
            }
        }

        $response['success'] = true;
        $response['data']['list'] = array_reverse($list);

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function getItem(Request $request, $name)
    {

        if(!\Auth::user()->hasPermission('has-access-of-advanced-section'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }


        $response['success'] = true;
        $response['data'] = [];

        $folder_path = storage_path('logs');

        $folder_path = str_replace("\\", "/", $folder_path);

        $path = $folder_path.'/'.$name;

        $response['data']['name'] = $name;
        $response['data']['path'] = $path;

        $file_name_array = explode(".",$name);

        if(File::exists($path) && $file_name_array[1] && $file_name_array[1] == 'log')
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
            $response['data']['logs'] = array_reverse($logs);


        }


        return response()->json($response);
    }

    //----------------------------------------------------------
    public function downloadFile(Request $request,$file_name)
    {

        if(!\Auth::user()->hasPermission('has-access-of-advanced-section'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        if(!$file_name || !File::exists(storage_path('logs/',$file_name))){
            return 'No File Found.';
        }

        $file_path =  storage_path('logs/').$file_name;

        return response()->download($file_path);
    }
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

        $folder_path = storage_path('logs');

        $response['success'] = true;
        $response['data']['message'] = 'success';

        switch ($action)
        {
            //------------------------------------
            case 'bulk-delete-all':

                VaahFiles::deleteFolder($folder_path);

                $response['messages'][] = 'Successfully delete all logs';

                break;

            //------------------------------------
            case 'bulk-delete':

                VaahFiles::deleteFile($request->path);

                $response['messages'][] = 'Successfully delete';

                break;

            //------------------------------------
            case 'clear-file':

                VaahFiles::writeFile($request->path, '');

                $response['messages'][] = 'Successfully clear';

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
