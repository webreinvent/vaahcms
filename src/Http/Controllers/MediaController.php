<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

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


}
