<?php

namespace WebReinvent\VaahCms\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use VaahCms\Modules\Cms\Entities\MenuItem;
use WebReinvent\VaahCms\Libraries\VaahSeeder;
use WebReinvent\VaahCms\Models\Module;
use WebReinvent\VaahCms\Models\Theme;
use WebReinvent\VaahCms\Models\User;
use WebReinvent\VaahExtend\Libraries\VaahArtisan;
use Faker\Factory;
use WebReinvent\VaahExtend\Libraries\VaahDB;

class WelcomeController extends Controller
{

    public $theme;

    //----------------------------------------------------------
    public function __construct()
    {

    }

    //----------------------------------------------------------
    public function clearCache(Request $request)
    {
        $response = VaahArtisan::clearCache();
        if(isset($response['success']) && !$response['success'])
        {
            return $response;
        }

        try{
            $files = ['config.php', 'packages.php', 'services.php'];
            $path = base_path().'/bootstrap/cache/';
            foreach ($files as $file)
            {
                if(\File::exists($path.$file))
                {
                    \File::delete($path.$file);
                }
            }

            $response['success'] = true;
            $response['messages'][] = 'Cache was successfully deleted.';

        }catch(\Exception $e)
        {
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return $response;
    }
    //----------------------------------------------------------
    public function index(Request $request)
    {

        if(app()->runningInConsole())
        {
            return true;
        }

        $errors = [];

        $message = 'Install VaahCMS and activate the CMS module or define your own routes.';

        if(!VaahDB::isConnected())
        {
            $errors[] = $message;
            return view($request->theme_slug.'::frontend.welcome')->withErrors($errors);
        }

        if(!VaahDB::isTableExist('vh_modules'))
        {
            $errors[] = $message;
            return view($request->theme_slug.'::frontend.welcome')->withErrors($errors);
        }

        $is_cms_exists = Module::slug('cms')->active()->exists();

        if(!$is_cms_exists)
        {
            $errors[] = $message;
            return view($request->theme_slug.'::frontend.welcome')->withErrors($errors);
        }

        $is_theme_active = Theme::active()->exists();

        if(!$is_theme_active)
        {
            $errors[] = 'Install a theme and activate it.';
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
            //if dedicated welcome files does not exist in activated theme
            if (!view()->exists($this->theme.'::frontend.welcome')) {
                $errors[] = 'Activated theme does not have any welcome (frontend/welcome.blade.php) file.';
                $errors[] = 'Please read theme documentation.';
                return view(config('vaahcms.backend_theme').'::frontend.theme-welcome')
                    ->withErrors($errors);
            }

            return view($this->theme.'::frontend.welcome');
        }

        $blade = $menu_item->content->theme->slug.'::'.$menu_item->content->template->file_path;

        return view($blade)->with('data', $menu_item->content);
    }

    //----------------------------------------------------------
    public function getFaker(Request $request)
    {
        return VaahSeeder::fill($request);
    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
