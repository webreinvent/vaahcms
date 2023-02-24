<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Entities\Media;
use Illuminate\Support\Facades\File;

class MediaController extends Controller
{


    //----------------------------------------------------------
    public function __construct()
    {

    }
    //----------------------------------------------------------
    public function upload(Request $request)
    {


        $allowed_file_upload_size = config('vaahcms.allowed_file_upload_size');

        $input_file_name = null;
        $rules = array(
            'folder_path' => 'required',
            'file' => 'max:'.$allowed_file_upload_size,
        );

        if($request->has('file_input_name'))
        {
            $rules[$request->file_input_name] = 'required';
            $input_file_name = $request->file_input_name;
        } else{
            $rules['file'] = 'required';
            $input_file_name = 'file';
        }



        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        try{

            //add year and month folder
            if($request->folder_path == 'public/media')
            {
                $request->folder_path = $request->folder_path."/".date('Y')."/".date('m');
            }

            $data['extension'] = $request->file($input_file_name)->extension();
            $data['original_name'] = $request->file($input_file_name)->getClientOriginalName();
            $data['mime_type'] = $request->file($input_file_name)->getClientMimeType();
            $type = explode('/',$data['mime_type']);
            $data['type'] = $type[0];
            $data['size'] = $request->file($input_file_name)->getSize();

            if($request->file_name && !is_null($request->file_name)
                && $request->file_name != 'null')
            {
                $upload_file_name = Str::slug($request->file_name).'.'.$data['extension'];

                $upload_file_path = 'storage/app/'.$request->folder_path.'/'.$upload_file_name;

                $full_upload_file_path = base_path($upload_file_path);

                //if file already exist then prefix if with microtime
                if(File::exists($full_upload_file_path))
                {
                    $time_stamp = \Carbon\Carbon::now()->timestamp;
                    $upload_file_name = Str::slug($request->file_name).'-'.$time_stamp.'.'.$data['extension'];
                }
                $path = $request->file($input_file_name)
                    ->storeAs($request->folder_path, $upload_file_name);

                $data['name'] = $request->file_name;
                $data['uploaded_file_name'] = $data['name'].'.'.$data['extension'];

            } else{
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
            if($data['type'] == 'image')
            {
                $image = \Image::make($data['full_path'])->fit(180, 101, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $name_details = pathinfo($data['full_path']);
                $thumbnail_name = $name_details['filename'].'-thumbnail.'.$name_details['extension'];
                $thumbnail_path = $request->folder_path.'/'.$thumbnail_name;
                \Storage::put($thumbnail_path, (string) $image->encode());

                if (substr($thumbnail_path, 0, 6) =='public') {
                    $data['url_thumbnail'] = 'storage'.substr($thumbnail_path, 6);
                }

            }

            $response['status'] = 'success';
            $response['data'] = $data;

        }catch(\Exception $e)
        {
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
    public function getAssets(Request $request)
    {

        try{

            if(!\Auth::user()->hasPermission('has-access-of-media-section'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }


            $year_and_month = Media::getDateList();

            $data['bulk_actions'] = vh_general_bulk_actions();
            $data['allowed_file_types'] = vh_file_pond_allowed_file_type();
            $data['download_url'] = route('vh.frontend.media.download').'/';
            $data['date'] = $year_and_month;

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
    public function isDownloadableSlugAvailable(Request $request)
    {

        try{

            $rules = array(
                'download_url' => 'required',
            );


            $validator = \Validator::make( $request->all(), $rules);
            if ( $validator->fails() ) {

                $errors             = errorsToArray($validator->errors());
                $response['status'] = 'failed';
                $response['errors'] = $errors;
                return response()->json($response);
            }

            $data = [];

            $exist = Media::where('download_url', $request->download_url)
                ->first();

            if(!$exist)
            {
                $response['status'] = 'success';
                $response['messages'][] = 'Url is available';
                $response['data'] = true;
            } else
            {
                $response['status'] = 'failed';
                $response['errors'][] = 'Url is taken';
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
    public function postCreate(Request $request)
    {

        try{

            if(!\Auth::user()->hasPermission('can-create-media'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }

            $response = Media::createItem($request);

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
    public function getList(Request $request)
    {

        try{

            if(!\Auth::user()->hasPermission('has-access-of-media-section'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }

            $response = Media::getList($request);

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
    public function getItem(Request $request, $id)
    {

        try{

            if(!\Auth::user()->hasPermission('can-read-media'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }

            $request->merge(['id'=>$id]);
            $response = Media::getItem($request);

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
    public function postStore(Request $request)
    {

        try{

            if(!\Auth::user()->hasPermission('can-update-media'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }

            $response = Media::postStore($request);

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
    public function postActions(Request $request, $action)
    {

        try{

            $rules = array(
                'inputs' => 'required',
            );

            $validator = \Validator::make( $request->all(), $rules);
            if ( $validator->fails() ) {

                $errors             = errorsToArray($validator->errors());
                $response['status'] = 'failed';
                $response['errors'] = $errors;
                return response()->json($response);
            }

            $response = [];

            switch ($action)
            {

                //------------------------------------
                case 'bulk-change-status':
                    $response = Media::bulkStatusChange($request);
                    break;
                //------------------------------------
                case 'bulk-trash':

                    $response = Media::bulkTrash($request);

                    break;
                //------------------------------------
                case 'bulk-restore':

                    $response = Media::bulkRestore($request);

                    break;

                //------------------------------------
                case 'bulk-delete':

                    $response = Media::bulkDelete($request);

                    break;
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
