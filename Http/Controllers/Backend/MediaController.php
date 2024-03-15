<?php namespace WebReinvent\VaahCms\Http\Controllers\Backend;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

use WebReinvent\VaahCms\Models\Media;

class MediaController extends Controller
{
    //----------------------------------------------------------
    public function __construct()
    {
    }
    //----------------------------------------------------------
    public function getAssets(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-media-section';

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

            $model = new Media();
            $fillable = $model->getFillable();
            $data['fillable']['columns'] = array_diff(
                $fillable, $data['fillable']['except']
            );

            foreach ($fillable as $column) {
                if ($column === 'is_downloadable') {
                    $data['empty_item'][$column] = 0;
                    continue;
                }
                $data['empty_item'][$column] = null;
            }

            $data['actions'] = [];
            $data['language_strings'] = [
                "media_title" => trans("vaahcms-media.media_title"),
                "total_medias_heading" => trans("vaahcms-media.total_medias_heading"),
                "total_file_size_heading" => trans("vaahcms-media.total_file_size_heading"),
                "trashed_file_size_heading" => trans("vaahcms-media.trashed_file_size_heading"),
                "toolkit_text_open_image" => trans("vaahcms-media.toolkit_text_open_image"),
                "filter_month" => trans("vaahcms-media.filter_month"),
                "filter_year" => trans("vaahcms-media.filter_year"),
                "filter_date" => trans("vaahcms-media.filter_date"),
                "filter_with_trashed" => trans("vaahcms-media.filter_with_trashed"),

            ];

            $year_and_month = Media::getDateList();

            $data['bulk_actions'] = vh_general_bulk_actions();
            $data['allowed_file_types'] = vh_file_pond_allowed_file_type();
            $upload_allowed_file_size = config('settings.global.upload_allowed_file_size',5);
            $data['max_file_size'] = $upload_allowed_file_size* (1024 * 1024);
            $data['download_url'] = route('vh.frontend.media.download').'/';
            $data['date'] = $year_and_month;

            $response['success'] = true;
            $response['data'] = $data;
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-media-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = Media::getList($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function updateList(Request $request): JsonResponse
    {
        $permission_slug = 'can-update-media';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = Media::updateList($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function listAction(Request $request, $type): JsonResponse
    {
        $permission_slugs = ['can-update-media','can-manage-media'];

        $permission_response = Auth::user()->hasPermissions($permission_slugs);

        if(isset($permission_response['success']) && $permission_response['success'] == false) {
            return response()->json($permission_response);
        }


        try {
            $response = Media::listAction($request, $type);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function deleteList(Request $request): JsonResponse
    {
        $permission_slug = 'can-delete-media';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = Media::deleteList($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $id): JsonResponse
    {
        $permission_slug = 'can-read-media';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = Media::getItem($id);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function updateItem(Request $request, $id): JsonResponse
    {
        $permission_slug = 'can-update-media';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = Media::postStore($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function deleteItem(Request $request, $id): JsonResponse
    {
        $permission_slug = 'can-update-media';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = Media::deleteItem($request, $id);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function itemAction(Request $request, $id, $action): JsonResponse
    {
        $permission_slugs = ['can-update-media','can-manage-media'];

        $permission_response = Auth::user()->hasPermissions($permission_slugs);

        if(isset($permission_response['success']) && $permission_response['success'] == false) {
            return response()->json($permission_response);
        }

        try {
            $response = Media::itemAction($request, $id, $action);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function itemDownload(Request $request, $slug): BinaryFileResponse | JsonResponse
    {
        try {
            $media_data = Media::where('download_url', $slug)->first();
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }

            return response()->json($response);
        }

        return response()->download(storage_path(str_replace('storage','',$media_data->path)));
    }
    //----------------------------------------------------------
    public function upload(Request $request): JsonResponse
    {
        $allowed_file_upload_size = config('vaahcms.allowed_file_upload_size');

        $input_file_name = null;
        $rules = array(
            'folder_path' => 'required',
            'file' => 'max:'.$allowed_file_upload_size,
        );

        if ($request->has('file_input_name')) {
            $rules[$request->file_input_name] = 'required';
            $input_file_name = $request->file_input_name;
        } else {
            $rules['file'] = 'required';
            $input_file_name = 'file';
        }

        $validator = \Validator::make( $request->all(), $rules);

        if ( $validator->fails()) {
            $errors = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'][] = $errors;
            return response()->json($response);
        }


        try {
            //add year and month folder
            if ($request->folder_path == 'public/media') {
                $request->folder_path = $request->folder_path."/".date('Y')."/".date('m');
            }

            $data['extension'] = $request->file($input_file_name)->extension();
            $data['original_name'] = $request->file($input_file_name)->getClientOriginalName();
            $data['mime_type'] = $request->file($input_file_name)->getClientMimeType();
            $type = explode('/',$data['mime_type']);
            $data['type'] = $type[0];
            $data['size'] = $request->file($input_file_name)->getSize();

            if ($request->file_name && !is_null($request->file_name)
                && $request->file_name != 'null'
            ) {
                $upload_file_name = Str::slug($request->file_name).'.'.$data['extension'];

                $upload_file_path = 'storage/app/'.$request->folder_path.'/'.$upload_file_name;

                $full_upload_file_path = base_path($upload_file_path);

                //if file already exist then prefix if with microtime
                if (File::exists($full_upload_file_path)) {
                    $time_stamp = \Carbon\Carbon::now()->timestamp;
                    $upload_file_name = Str::slug($request->file_name).'-'.$time_stamp.'.'.$data['extension'];
                }

                $path = $request->file($input_file_name)
                    ->storeAs($request->folder_path, $upload_file_name);

                $data['name'] = $request->file_name;
                $data['uploaded_file_name'] = $data['name'].'.'.$data['extension'];

            } else {
                $path = $request->file($input_file_name)->store($request->folder_path);

                $data['name'] = $data['original_name'];
                $data['uploaded_file_name'] = $data['name'];
            }

            $data['slug'] = Str::slug($data['name']);
            //$data['extension'] = $name_details['extension'];

            $data['path'] = 'storage/app/'.$path;
            $data['full_path'] = base_path($data['path']);

            $data['url'] = $path;

            if (substr($path, 0, 6) =='public') {
                $data['url'] = 'storage'.substr($path, 6);
            }

            $data['full_url'] = asset($data['url']);

            //create thumbnail if image
            if ($data['type'] == 'image') {

                $manager = new ImageManager(
                    new Driver()
                );

                $image = $manager->read($data['full_path'])->scale(180, 101);

                $name_details = pathinfo($data['full_path']);
                $thumbnail_name = $name_details['filename'].'-thumbnail.'.$name_details['extension'];
                $thumbnail_path = $request->folder_path.'/'.$thumbnail_name;
                \Storage::put($thumbnail_path, (string) $image->encode());

                if (substr($thumbnail_path, 0, 6) =='public') {
                    $data['url_thumbnail'] = 'storage'.substr($thumbnail_path, 6);
                    $data['thumbnail_size'] = \Storage::size($thumbnail_path);
                }

            }

            $response['success'] = true;
            $response['data'] = $data;

        } catch(\Exception $e) {
            $response['success'] = false;
            $response['errors'][] = $e->getMessage();
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postCreate(Request $request): JsonResponse
    {
        $permission_slug = 'can-create-media';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = Media::createItem($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function isDownloadableSlugAvailable(Request $request): JsonResponse
    {
        try {
            $rules = array(
                'download_url' => 'required',
            );

            $validator = \Validator::make( $request->all(), $rules);
            if ( $validator->fails() ) {

                $errors = errorsToArray($validator->errors());
                $response['success'] = false;
                $response['errors'][] = $errors;
                return response()->json($response);
            }

            $data = [];

            $exist = Media::query()
                ->where('download_url', $request->download_url)
                ->first();

            if (!$exist) {
                $response['success'] = true;
                $response['messages'][] = 'Url is available';
                $response['data'] = true;
            } else {
                $response['success'] = false;
                $response['errors'][] = 'Url is taken';
            }
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
}
