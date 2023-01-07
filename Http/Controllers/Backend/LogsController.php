<?php namespace WebReinvent\VaahCms\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use WebReinvent\VaahCms\Models\Job;
use WebReinvent\VaahExtend\Libraries\VaahFiles;


class LogsController extends Controller
{


    //----------------------------------------------------------
    public function __construct()
    {

    }

    //----------------------------------------------------------

    public function getAssets(Request $request)
    {

        $data = [];

        $data['permission'] = [];
        $data['rows'] = config('vaahcms.per_page');

        $data['fillable']['except'] = [
            'uuid',
            'created_by',
            'updated_by',
            'deleted_by',
        ];

        $model = new Job();
        $fillable = $model->getFillable();
        $data['fillable']['columns'] = array_diff(
            $fillable, $data['fillable']['except']
        );

        foreach ($fillable as $column)
        {
            $data['empty_item'][$column] = null;
        }

        $data['actions'] = [];

        $response['success'] = true;
        $response['data'] = $data;

        return $response;
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
//    public function updateList(Request $request)
//    {
//        return Job::updateList($request);
//    }
    //----------------------------------------------------------
    public function listAction(Request $request, $type)
    {
        return Job::listAction($request, $type);
    }
    //----------------------------------------------------------
    public function deleteList(Request $request)
    {
        return Job::deleteList($request);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $id)
    {
        return Job::getItem($id);
    }
    //----------------------------------------------------------
    public function deleteItem(Request $request,$id)
    {
        return Job::deleteItem($request,$id);
    }
    //----------------------------------------------------------
    public function itemAction(Request $request,$id,$action)
    {
        return Job::itemAction($request,$id,$action);
    }
    //----------------------------------------------------------


}
