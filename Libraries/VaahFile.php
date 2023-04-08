<?php
namespace WebReinvent\VaahCms\Libraries;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class VaahFile{

    //------------------------------------------------------------
    public function upload($request) {



        if(!$request->hasFile('file')){
            $response['success'] = false;
            $response['errors'][] = 'No file to upload.';
            return  $response;
        }

        $file_params = $this->getUploadFileParams($request);

        $request->merge($file_params);

        $rules = array(
            'file' => 'required',
            'path' => 'required',
            'allowed_extensions' => 'required|array',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }

        if(!in_array($request->file_extension, $request->allowed_extensions))
        {
            $response['success'] = false;
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
            $response['success'] = false;
            $response['errors'][] = $e->getMessage();
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
    public static function createFile($path, $file_name, $content)
    {

        try{
            if(!File::exists($path)) {
                File::makeDirectory($path, 0755, true, true);
            }

            $file_path = $path.$file_name;



            $file = File::put($file_path, $content);
            $response['success'] = true;
            $response['data']['file'] = $file;

        }catch(\Exception $e)
        {
            $response['success'] = false;
            $response['errors'][] = $e->getMessage();
        }

        return $response;

    }
    //------------------------------------------------------------
    public static function createJsonFileFromArray($array, $file_name, $path=null)
    {
        $file_path = null;

        if(!$path)
        {
            $path = base_path('/');
        }


        if (is_array($array)) {

            $content = stripslashes(json_encode($array, JSON_PRETTY_PRINT));


            $response = static::createFile($path, $file_name, $content);

            return $response;
        }

    }

    //------------------------------------------------------------

    //------------------------------------------------------------
    //------------------------------------------------------------
    //------------------------------------------------------------
    //------------------------------------------------------------

}
