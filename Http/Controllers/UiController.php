<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Models\User;

class UiController extends Controller
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
        return view($this->theme.'.pages.ui.index');
    }
    //----------------------------------------------------------
    public function v2ui()
    {
        $this->theme = 'vaahcms::backend.vaahtwo';
        return view($this->theme.'.pages.ui');
    }
    //----------------------------------------------------------


}
