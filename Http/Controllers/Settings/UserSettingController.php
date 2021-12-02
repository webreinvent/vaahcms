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
use WebReinvent\VaahCms\Entities\User;
use WebReinvent\VaahCms\Libraries\VaahBackup;
use WebReinvent\VaahCms\Libraries\VaahHelper;
use WebReinvent\VaahCms\Libraries\VaahSetup;


class UserSettingController extends Controller
{

    //----------------------------------------------------------
    public function __construct()
    {

    }

    //----------------------------------------------------------
    public function getAssets(Request $request)
    {

        if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $data['timezones'] = vh_get_timezones();
        $data['country_calling_codes'] = vh_get_countries_calling_codes();

        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {

        if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $data = [];

        foreach (User::$setting_column as $key => $column){
            $data['list'][$key] = [
                'name' => $column,
                'is_hidden' => 0,
                'for_permission' => false,
            ];
        }

        $response['status'] = 'success';
        $response['data'] = $data;

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

        return response()->json($response);

    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
