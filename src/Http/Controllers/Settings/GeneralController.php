<?php

namespace WebReinvent\VaahCms\Http\Controllers\Settings;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use WebReinvent\VaahCms\Entities\Role;
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

        return response()->json($response);
    }
    //----------------------------------------------------------

    //----------------------------------------------------------
    //----------------------------------------------------------


}
