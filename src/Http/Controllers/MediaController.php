<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Entities\Media;

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

        if($request->has('file_name'))
        {
            $rules[$request->file_name] = 'required';
            $input_file_name = $request->file_name;
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

            $path = $request->file($input_file_name)->store($request->folder_path);


            $data['full_name'] = $request->file('file')->getClientOriginalName();
            $name_details = pathinfo($data['full_name']);
            $data['name'] = $name_details['filename'];
            $data['slug'] = Str::slug($data['name']);
            $data['extension'] = $name_details['extension'];

            $data['type'] = $request->file('file')->extension();
            $data['mime_type'] = $request->file('file')->getClientMimeType();

            $data['path'] = $path;
            $data['full_path'] = app_path($path);

            $data['url'] = $path;

            if (substr($path, 0, 6) =='public') {
                $data['url'] = 'storage'.substr($path, 6);
            }

            $data['full_url'] = asset($data['url']);

            $response['status'] = 'success';
            $response['data'] = $data;

        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function getAssets(Request $request)
    {

        if(!\Auth::user()->hasPermission('has-access-of-media-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }


        $data['allowed_file_types'] = vh_file_pond_allowed_file_type();

        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postCreate(Request $request)
    {

        if(!\Auth::user()->hasPermission('can-create-media'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $response = Media::createItem($request);

        if($response['status'] == 'success')
        {
            $list = Media::getList($request);
            $response['data']['list'] = $list['data']['list'];
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {
        if(!\Auth::user()->hasPermission('has-access-of-media-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $response = Media::getList($request);
        return response()->json($response);
    }

    //----------------------------------------------------------
    public function getItem(Request $request, $id)
    {

        if(!\Auth::user()->hasPermission('can-read-media'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $request->merge(['id'=>$id]);
        $response = Media::getItem($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postStore(Request $request)
    {

        if(!\Auth::user()->hasPermission('can-update-media'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $response = Media::store($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postActions(Request $request, $action)
    {

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

        return response()->json($response);

    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
