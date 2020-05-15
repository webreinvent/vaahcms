<?php

namespace WebReinvent\VaahCms\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use VaahCms\Modules\Cms\Entities\MenuItem;
use WebReinvent\VaahCms\Entities\Module;
use WebReinvent\VaahCms\Entities\Theme;

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

        $errors = [];
        $is_cms_exists = Module::slug('cms')->active()->exists();

        if(!$is_cms_exists)
        {
            $errors[] = 'Install and Activate CMS Module.';
            return view($this->theme.'::frontend.welcome')->withErrors($errors);
        }

        $is_theme_active = Theme::active()->count();

        //if CMS module is not installed or active
        if($is_theme_active < 1)
        {
            $errors[] = 'Install and Activate at least one theme.';
            return view($this->theme.'::frontend.welcome')->withErrors($errors);
        }


        $menu_item = MenuItem::where('is_home', 1)->first();

        if(!$menu_item)
        {

            //check if dedicated home page is exist
            if (view()->exists($this->theme.'::home')) {
                return view($this->theme.'::home');
            } else {
                return view($this->theme.'::default');
            }

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
