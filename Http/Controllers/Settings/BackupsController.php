<?php

namespace WebReinvent\VaahCms\Http\Controllers\Settings;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use WebReinvent\VaahCms\Entities\Role;
use WebReinvent\VaahCms\Libraries\VaahBackup;


class BackupsController extends Controller
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

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {
        $response = VaahBackup::create($request);

        return response()->json($response);
    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
