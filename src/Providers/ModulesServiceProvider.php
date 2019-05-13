<?php

namespace WebReinvent\VaahCms\Providers;

use Illuminate\Support\ServiceProvider;
use WebReinvent\VaahCms\Modules\ModulesLoader;


class ModulesServiceProvider extends ServiceProvider
{
    /**
     * Booting the package.
     */
    public function boot()
    {



    }

    /**
     * Register the provider.
     */
    public function register()
    {

        $this->app->singleton('ModulesLoader', function($app)
        {
            return new ModulesLoader($app['files'], config('vaahcms.modules_path'));
        });

        $module_manager = $this->app->make('ModulesLoader');

        // Register Service Providers of all the active modules in a loop
        foreach ($module_manager->findModules() as $module)
        {
            if(!isset($module['active']) || $module['active'] != 1 )
            {
                continue;
            }

            foreach ($module['providers'] as $provider)
            {
                $this->app->register($provider);
            }
        }

    }

    //----------------------------------------------------

    //----------------------------------------------------
    //----------------------------------------------------
    //----------------------------------------------------
    //----------------------------------------------------
}
