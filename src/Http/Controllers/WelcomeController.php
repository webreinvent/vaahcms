<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use VaahCms\Modules\Cms\Entities\MenuItem;
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

        $menu_item = MenuItem::where('is_home', 1)->first();

        if(!$menu_item)
        {
            return view($this->theme.'::default');
        }

        $template_name = 'default';

        $page = $menu_item->page()->first();

        if($page->template)
        {
            $template_name = $page->template->slug;
        }


        return view($this->theme.'::page-templates.'.$template_name)->with('data', $page);


    }
    //----------------------------------------------------------

    public function getPage(Request $request,$slug)
    {

        $data = [];

        $page = $request->page;

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
