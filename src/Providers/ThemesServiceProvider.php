<?php

namespace WebReinvent\VaahCms\Providers;

use Illuminate\Support\ServiceProvider;
use WebReinvent\VaahCms\Loaders\ThemesLoader;


class ThemesServiceProvider extends ServiceProvider
{
    /**
     * Booting the package.
     */
    public function boot()
    {

        $path = base_path()."/".config('vaahcms.themes_path');
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


        $path = base_path()."/".config('vaahcms.themes_path');
        $this->app->singleton('ThemesLoader', function($app) use ($path)
        {
            return new ThemesLoader($app['files'], $path);
        });

        $themes_manager = $this->app->make('ThemesLoader');

        // Register Service Providers of all the active modules in a loop
        foreach ($themes_manager->findList() as $theme)
        {
            foreach ($theme['providers'] as $provider)
            {
                $this->app->register($provider);
            }
        }


        /*

        if (!\Schema::hasTable('vh_modules')) {
            return false;
        }

        $this->app->singleton('ModulesLoader', function($app)
        {
            return new ModulesLoader($app['files'], config('vaahcms.modules_path'));
        });

        $module_manager = $this->app->make('ModulesLoader');

        // Register Service Providers of all the active modules in a loop
        foreach ($module_manager->findModules() as $module)
        {

            $db_module = Module::where('slug', $module['slug'])->first();

            if(!$db_module)
            {
                continue;
            }

            if($db_module->is_active != 1 )
            {
                continue;
            }

            foreach ($module['providers'] as $provider)
            {
                $this->app->register($provider);
            }
        }


        */

    }
    //----------------------------------------------------

    //----------------------------------------------------
    //----------------------------------------------------
    //----------------------------------------------------
    //----------------------------------------------------
}
