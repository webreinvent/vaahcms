<?php

namespace WebReinvent\VaahCms\Providers;

use Illuminate\Support\ServiceProvider;
use WebReinvent\VaahCms\Entities\Module;
use WebReinvent\VaahCms\Loaders\ModulesLoader;


class ModulesServiceProvider extends ServiceProvider
{
    /**
     * Booting the package.
     */
    public function boot()
    {

        if(\File::exists(config('vaahcms.modules_path')))
        {
            $this->registerModuleServiceProviders();
        }

    }

    /**
     * Register the provider.
     */
    public function register()
    {


    }

    //----------------------------------------------------
    public function registerModuleServiceProviders()
    {

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
    }
    //----------------------------------------------------

    //----------------------------------------------------
    //----------------------------------------------------
    //----------------------------------------------------
    //----------------------------------------------------
}
