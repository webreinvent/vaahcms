<?php

namespace WebReinvent\VaahCms\Http\Controllers\Admin\Settings;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\User;

class SettingsController extends Controller
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
        return view($this->theme.'.pages.dashboard');
    }
    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------


}
