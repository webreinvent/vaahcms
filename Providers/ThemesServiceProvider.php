<?php

namespace WebReinvent\VaahCms\Providers;

use Illuminate\Support\ServiceProvider;
use WebReinvent\VaahCms\Libraries\VaahSetup;
use WebReinvent\VaahCms\Loaders\ThemesLoader;
use WebReinvent\VaahCms\Models\Theme;


class ThemesServiceProvider extends ServiceProvider
{
    /**
     * Booting the package.
     */
    public function boot()
    {

        $path = config('vaahcms.themes_path');
        if(\File::exists($path))
        {
            $this->registerThemeServiceProviders();
        }

    }

    /**
     * Register the provider.
     */
    public function register()
    {


    }

    //----------------------------------------------------
    public function registerThemeServiceProviders()
    {


        if (!\Schema::hasTable('vh_themes')) {
            return false;
        }

        $path = config('vaahcms.themes_path');

        $this->app->singleton('ThemesLoader', function($app) use ($path)
        {
            return new ThemesLoader($app['files'], $path);
        });

        $theme_manager = $this->app->make('ThemesLoader');


        // Register Service Providers of all the active modules in a loop
        if(VaahSetup::isDBConnected() && VaahSetup::isDBMigrated())
        {
            foreach ($theme_manager->findList() as $theme)
            {

                $db_theme = Theme::where('slug', $theme['slug'])->first();

                if(!$db_theme)
                {
                    continue;
                }

                if($db_theme->is_active != 1 )
                {
                    continue;
                }



                foreach ($theme['providers'] as $provider)
                {
                    $this->app->register($provider);
                }
            }
        }




    }
    //----------------------------------------------------

    //----------------------------------------------------
    //----------------------------------------------------
    //----------------------------------------------------
    //----------------------------------------------------
}
