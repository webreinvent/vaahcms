<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\User;

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

        try{

            $response['status'] = 'success';
            $response['data']['item'] = vh_action('getDashboardItems');

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);

    }
    //----------------------------------------------------------


}
