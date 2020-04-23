<?php

namespace WebReinvent\VaahCms\Http\Controllers\Settings;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use WebReinvent\VaahCms\Entities\Language;
use WebReinvent\VaahCms\Entities\Role;
use WebReinvent\VaahCms\Entities\Setting;
use WebReinvent\VaahCms\Libraries\VaahBackup;


class GeneralController extends Controller
{

    //----------------------------------------------------------
    public function __construct()
    {

    }

    //----------------------------------------------------------
    public function getAssets(Request $request)
    {

        $response['status'] = 'success';
        $response['data']['roles'] = Role::getActiveRoles();
        $response['data']['file_types'] = vh_file_types();
        $response['data']['vh_meta_attributes'] = vh_meta_attributes();
        $response['data']['languages'] = Language::select('name', 'locale_code_iso_639')->get();

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {

        $data = [];

        $data['list'] = Setting::getGlobalSettings($request);

        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);

    }

    //----------------------------------------------------------
    //----------------------------------------------------------


}
