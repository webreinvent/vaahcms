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
            $errors[] = 'Install and activate a theme.';
            return view($this->theme.'::frontend.welcome')->withErrors($errors);
        }

        $is_theme_active = Theme::active()->count();

        //if CMS module is not installed or active
        if($is_theme_active < 1)
        {
            $errors[] = 'No theme is marked as active.';
            return view($this->theme.'::frontend.welcome')->withErrors($errors);
        }

        $menu_item = MenuItem::getHomePage();


        if(!$menu_item)
        {
            //check if dedicated home page is exist
            if (view()->exists()) {
                return view($this->theme.'::frontend.home');
            } else {
                return view($this->theme.'::frontend.default');
            }
        }

        $blade = $menu_item->content->theme->slug.'::'.$menu_item->content->template->file_path;


        return view($blade)->with('content', $menu_item->content);


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
