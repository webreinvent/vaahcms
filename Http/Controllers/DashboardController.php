<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Models\User;

class DashboardController extends Controller
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
        return view($this->theme.'.pages.dashboard');
    }
    //----------------------------------------------------------
    public function layoutApp(Request $request)
    {
        return view($this->theme.'.pages.app');

    }
    //----------------------------------------------------------
    public function vaah(Request $request)
    {
        return view($this->theme.'.pages.vaah');

    }
    //----------------------------------------------------------
    public function getItem(Request $request)
    {
        $response['success'] = true;
        $response['data'] = [];
        $response['data']['theme_doc_url'] = 'https://docs.vaah.dev/vaahcms-2x/theme/introduction';
        $response['data']['item'] = vh_action('getDashboardItems');
        $response['data']['language_strings'] = [
            "greeting" => trans("vaahcms-dashboard.welcome_to_vaahcms"),
            'message' => trans("vaahcms-dashboard.welcome_message"),
            'get_started' => trans("vaahcms-dashboard.get_started"),
            'next_steps' => trans("vaahcms-dashboard.next_steps"),
            'more_actions' => trans("vaahcms-dashboard.more_actions"),
            'go_to_theme' => trans("vaahcms-dashboard.go_to_theme"),
            'activate_theme' => trans("vaahcms-dashboard.activate_theme"),
            'or' => trans("vaahcms-dashboard.or"),
            'create_your_own_theme' => trans("vaahcms-dashboard.create_your_own_theme"),
        ];

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function getVaahExtendUi()
    {
        return view($this->theme.'.pages.vaahextend');
    }
    //----------------------------------------------------------


}
