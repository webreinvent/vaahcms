<?php

namespace WebReinvent\VaahCms\Http\Controllers\Settings;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Libraries\VaahBackup;
use WebReinvent\VaahCms\Models\Role;

class BackupsController extends Controller
{
    // ----------------------------------------------------------
    public function __construct() {}

    // ----------------------------------------------------------
    public function getAssets(Request $request)
    {
        $permission_slug = 'has-access-of-setting-section';

        if (! \Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        $response['success'] = true;
        $response['data']['roles'] = Role::getActiveRoles();

        return response()->json($response);
    }

    // ----------------------------------------------------------
    public function getList(Request $request)
    {
        $permission_slug = 'has-access-of-setting-section';

        if (! \Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        $response = VaahBackup::create($request);

        return response()->json($response);
    }
    // ----------------------------------------------------------
    // ----------------------------------------------------------

}
