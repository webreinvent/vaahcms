<?php

namespace WebReinvent\VaahCms\Http\Controllers\Settings;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use WebReinvent\VaahCms\Libraries\VaahBackup;
use WebReinvent\VaahCms\Models\Role;


class BackupsController extends Controller
{

    //----------------------------------------------------------
    public function __construct()
    {

    }

    //----------------------------------------------------------
    public function getAssets(Request $request)
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!\Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
        }

        $response['success'] = true;
        $response['data']['roles'] = Role::getActiveRoles();

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!\Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
        }

        $response = VaahBackup::create($request);

        return response()->json($response);
    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
