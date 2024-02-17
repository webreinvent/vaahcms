<?php namespace WebReinvent\VaahCms\Http\Controllers\Backend\Advanced;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use WebReinvent\VaahCms\Models\Job;
use WebReinvent\VaahExtend\Libraries\VaahFiles;

class LogsController extends Controller
{
    //----------------------------------------------------------
    public function __construct()
    {
    }
    //----------------------------------------------------------
    public function getAssets(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-advanced-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
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

            foreach ($fillable as $column) {
                $data['empty_item'][$column] = null;
            }

            $data['actions'] = [];
            $data['language_strings'] = [
                "logs" => trans("vaahcms-sidebar-menu.logs"),
                "filter_by_extension" => trans("vaahcms-general.filter_by_extension"),
                "toolkit_text_reload" => trans("vaahcms-general.toolkit_text_reload"),
                "toolkit_text_close" => trans("vaahcms-general.toolkit_text_close"),
                "toolkit_text_clear_file" => trans("vaahcms-general.toolkit_text_clear_file"),
                "toolkit_text_download_file" => trans("vaahcms-general.toolkit_text_download_file"),
                "view_log_file" => trans("vaahcms-general.view_log_file"),

            ];
            $response['success'] = true;
            $response['data'] = $data;
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function getList(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-logs-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $folder_path = storage_path('logs');

            $folder_path = str_replace("\\", "/", $folder_path);

            $list = [];

            if (File::isDirectory($folder_path)) {
                $files = VaahFiles::getAllFiles($folder_path);
                $i = 1;

                if (count($files) > 0) {
                    foreach ($files as $file) {

                        if ($request['filter'] && isset($request['filter']['file_type'])
                            && count($request['filter']['file_type']) > 0)
                        {

                            $file_name_array = explode(".", $file);

                            if (count($file_name_array) > 1
                                && in_array('.'.$file_name_array[1], $request['filter']['file_type']) ) {

                                if ($request->has('q') && $request->q) {
                                    if (stripos($file, $request->q) !== FALSE) {
                                        $list[] = [
                                            'id' => $i,
                                            'name' => $file,
                                            'path' => $folder_path . '/' . $file,
                                            'size' => $this->getFileSize($folder_path . '/' . $file)
                                        ];
                                    }
                                } else {
                                    $list[] = [
                                        'id' => $i,
                                        'name' => $file,
                                        'path' => $folder_path . '/' . $file,
                                        'size' => $this->getFileSize($folder_path . '/' . $file)
                                    ];
                                }

                                $i++;


                            }
                        } elseif ($request['filter'] && $request['filter']['q']) {

                            if (stripos($file, $request['filter']['q']) === FALSE) {
                                continue;
                            }
                            $list[] = [
                                'id' => $i,
                                'name' => $file,
                                'path' => $folder_path . '/' . $file,
                                'size' => $this->getFileSize($folder_path . '/' . $file)
                            ];

                            $i++;
                        } else {

                            $list[] = [
                                'id' => $i,
                                'name' => $file,
                                'path' => $folder_path . '/' . $file,
                                'size' => $this->getFileSize($folder_path . '/' . $file)
                            ];

                            $i++;

                        }
                    }
                }
            }

            $response['success'] = true;
            $response['data']['list'] = array_reverse($list);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $name): JsonResponse
    {
        $permission_slug = 'has-access-of-advanced-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response['success'] = true;
            $response['data'] = [];

            $folder_path = storage_path('logs');

            $folder_path = str_replace("\\", "/", $folder_path);

            $path = $folder_path.'/'.$name;

            $response['data']['name'] = $name;
            $response['data']['path'] = $path;

            $file_name_array = explode(".",$name);

            if (!File::exists($path)) {
                $response['success'] = false;
                $response['errors'] = [];
                return response()->json($response);
            }

            if ($file_name_array[1] && $file_name_array[1] == 'log') {
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
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function downloadFile(Request $request, $file_name): BinaryFileResponse | string | JsonResponse
    {
        $permission_slug = 'has-access-of-advanced-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            if(!$file_name || !File::exists(storage_path('logs/',$file_name))){
                return 'No File Found.';
            }

            $file_path =  storage_path('logs/').$file_name;
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }

            return response()->json($response);
        }

        return response()->download($file_path);
    }
    //----------------------------------------------------------
    public function postActions(Request $request, $action): JsonResponse
    {
        $permission_slug = 'has-access-of-advanced-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = [];

            $folder_path = storage_path('logs');

            $response['success'] = true;
            $response['data']['message'] = 'success';

            switch ($action)
            {
                //------------------------------------
                case 'bulk-delete-all':

                    VaahFiles::deleteFolder($folder_path);

                    $response['messages'][] = trans("vaahcms-general.successfully_delete_all_logs");

                    break;

                //------------------------------------
                case 'delete':

                    VaahFiles::deleteFile($request->path);

                    $response['messages'][] = trans("vaahcms-general.successfully_deleted");

                    break;

                //------------------------------------
                case 'clear-file':

                    VaahFiles::writeFile($request->path, '');

                    $response['messages'][] = trans("vaahcms-general.successfully_clear");

                    break;
                //------------------------------------
            }
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function getFileSize($file_path)
    {
        $size = File::size($file_path);

        $base = log($size) / log(1024);
        $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');

        return round(pow(1024, $base - floor($base)),1) . $suffixes[floor($base)];
    }
    //----------------------------------------------------------
}
