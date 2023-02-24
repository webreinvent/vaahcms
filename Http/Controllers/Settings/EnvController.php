<?php

namespace WebReinvent\VaahCms\Http\Controllers\Settings;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Entities\Language;
use WebReinvent\VaahCms\Entities\Role;
use WebReinvent\VaahCms\Entities\Setting;
use WebReinvent\VaahCms\Libraries\VaahBackup;
use WebReinvent\VaahCms\Libraries\VaahHelper;
use WebReinvent\VaahCms\Libraries\VaahSetup;


class EnvController extends Controller
{

    //----------------------------------------------------------
    public function __construct()
    {

    }

    //----------------------------------------------------------
    public function getAssets(Request $request)
    {

        try{

            if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }


            $data['is_installed'] = VaahSetup::isInstalled();
            $data['environments'] = vh_environments();
            $data['timezones'] = vh_get_timezones();
            $data['database_types'] = vh_database_types();
            $data['mail_encryption_types'] = vh_mail_encryption_types();
            $data['mail_sample_settings'] = vh_mail_sample_settings();
            $data['country_calling_codes'] = vh_get_countries_calling_codes();
            $data['app_url'] = url("/");

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
    public function getList(Request $request)
    {
        try{

            if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }

            $data = [];

            $data['env_file'] = VaahSetup::getActiveEnvFileName();
            $data['list'] = VaahSetup::getEnvFileVariables(null, 'list');

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
    public function downloadFile(Request $request,$file_name)
    {

        if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        if(!$file_name || !File::exists(base_path('/'.$file_name))){
            return 'No File Found.';
        }

        $file_path =  base_path('/'.$file_name);

        return response()->download($file_path);

    }

    //----------------------------------------------------------
    public function store(Request $request)
    {

        try{

            if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }

            $response = VaahSetup::generateEnvFile($request, 'list');

            if($response['status'] && $response['status'] == 'success')
            {
                VaahHelper::clearCache();
                $response['data']['redirect_url'] = route('vh.backend');
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
