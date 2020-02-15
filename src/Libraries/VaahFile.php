<?php
namespace WebReinvent\VaahCms\Libraries;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class VaahFile{

    //------------------------------------------------------------
    public function upload($request) {



        if(!$request->hasFile('file')){
            $response['status'] = 'failed';
            $response['errors'][] = 'No file to upload.';
            return  $response;
        }

        $file_params = $this->getUploadFileParams($request);

        echo "<pre>";
        print_r($file_params);
        echo "</pre>";
        die("<hr/>line number=123");

        $request->merge($file_params);

        $rules = array(
            'file' => 'required',
            'path' => 'required',
            'allowed_extensions' => 'required|array',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }

        if(!in_array($request->file_extension, $request->allowed_extensions))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'File extension '.$request->file_extension.' is not allowed to upload';
            return $response;
        }


        try{

            Storage::disk('local')->putFileAs(
                $request->upload_folder_path,
                $request->file('file'),
                $request->upload_file_name
            );

        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['messages'][] = $e->getMessage();
            return $response;
        }






    }
    //------------------------------------------------------------
    public function getUploadFileParams($request)
    {

        $params = $request->all();
        if(!$request->has('upload_folder_path'))
        {
            $date = date('y-m-d');
            $folder = storage_path('uploads/'.$date);
            $params['upload_folder_path'] = $folder;
        }

        if(!$request->has('file_name'))
        {
            $params['file_name'] = $request->file('file')->getClientOriginalName();
        }

        $params['file_extension'] = $request->file('file')->getClientOriginalExtension();

        $params['upload_file_name'] = $params['file_name'].".".$params['file_extension'];

        $params['upload_file_path'] = $params['upload_folder_path']."/".$params['upload_file_name'];

        if(File::exist($params['upload_file_path']))
        {
            $file_name = $params['file_name']."-".date('Y-m-d-H-i-s');
            $file_name = $file_name.".".$params['file_extension'];
            $params['upload_file_name'] = $file_name;
            $params['upload_file_path'] = $params['upload_folder_path']."/".$file_name;
        }


        if(!$request->has('allowed_extensions'))
        {
            $uploads = config('vaahcms.uploads');
            $allowed_extensions = $uploads['allowed_extensions'];
            $params['allowed_extensions'] = $allowed_extensions;
        }

        return $params;

    }
    //------------------------------------------------------------

    //------------------------------------------------------------
    //------------------------------------------------------------
    //------------------------------------------------------------
    //------------------------------------------------------------
    //------------------------------------------------------------

}
