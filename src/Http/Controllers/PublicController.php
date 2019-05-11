<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class PublicController extends Controller
{

    //----------------------------------------------------------
    public function login()
    {
        return view('vaahcms::frontend.login');
    }

    //----------------------------------------------------------


}
