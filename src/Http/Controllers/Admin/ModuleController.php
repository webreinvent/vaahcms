<?php

namespace WebReinvent\VaahCms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\User;
use ZanySoft\Zip\Zip;

class ModuleController extends Controller
{

    public $theme;

    //----------------------------------------------------------
    public function __construct()
    {
        $this->theme = vh_get_admin_theme();
    }

    //----------------------------------------------------------
    public function index()
    {
        return view($this->theme.'.pages.modules');
    }
    //----------------------------------------------------------
    public function assets(Request $request)
    {
        $data['vaahcms_api_route'] = config('vaahcms.api_route');
        $data['debug'] = config('vaahcms.debug');

        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function download(Request $request)
    {

        $filename = 'sample.zip';
        $path = base_path()."/vaahcms/Modules/".$filename;



        copy('https://github.com/webreinvent/vaahcms-sample-module/archive/master.zip', $path);


        try{
            Zip::check($path);

            $zip = Zip::open($path);
            $zip->extract(base_path().'/vaahcms/Modules/');
            $response['status'] = 'success';
            $response['messages'][] = 'installed';
            return response()->json($response);

        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
            return response()->json($response);
        }


    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {
        $rules = array(
            'name' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $data = [];

        $response['status'] = 'failed';
        $response['errors'][] = 'error';

        $response['status'] = 'success';
        $response['messages'][] = 'Saved';
        $response['data'] = $data;

        return response()->json($response);

    }
    //----------------------------------------------------------


}
