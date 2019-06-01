<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use VaahCms\Modules\Cms\Entities\Page;

class WelcomeController extends Controller
{

    public $theme;

    //----------------------------------------------------------
    public function __construct()
    {
        $this->theme = vh_get_theme_slug();
    }

    //----------------------------------------------------------
    public function index()
    {
        return view($this->theme.'::default');
    }
    //----------------------------------------------------------

    public function getPage(Request $request,$slug)
    {

        $data = [];

        $page = Page::where('slug', $slug)
            ->with(['template'])
            ->firstOrFail();

        $template_name = 'default';

        if($page->template)
        {
            $template_name = $page->template->slug;
        }

        return view($this->theme.'::page-templates.'.$template_name)->with('data', $page);

    }

    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------


}
