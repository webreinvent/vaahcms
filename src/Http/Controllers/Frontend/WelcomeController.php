<?php

namespace WebReinvent\VaahCms\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use VaahCms\Modules\Cms\Entities\MenuItem;
use VaahCms\Modules\Cms\Entities\Page;
use WebReinvent\VaahCms\Entities\Module;

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

        //if CMS module is not installed or active
        if(!Module::slug('cms')->active()->exists())
        {
            return view($this->theme.'::frontend.default');
        }

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


        return view($this->theme.'::frontend.page-templates.'.$template_name)->with('data', $page);


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
