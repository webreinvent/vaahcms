<?php

namespace WebReinvent\VaahCms\Http\Controllers\Settings;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Models\User;

class SettingsController extends Controller
{

    public $theme;

    //----------------------------------------------------------
    public function __construct()
    {
        $this->theme = vh_get_backend_theme();
    }

    //----------------------------------------------------------
    public function index()
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!\Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        return view($this->theme.'.pages.dashboard');
    }
    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------


}
