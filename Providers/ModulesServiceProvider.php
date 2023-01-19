<?php

namespace WebReinvent\VaahCms\Providers;

use Illuminate\Support\ServiceProvider;
use WebReinvent\VaahCms\Models\Module;
use WebReinvent\VaahCms\Libraries\VaahSetup;
use WebReinvent\VaahCms\Loaders\ModulesLoader;


class ModulesServiceProvider extends ServiceProvider
{
    /**
     * Booting the package.
     */
    public function boot()
    {
        $path = config('vaahcms.modules_path');

        if(\File::exists($path))
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

        $path = config('vaahcms.modules_path');

        $this->app->singleton('ModulesLoader', function($app) use ($path)
        {
            return new ModulesLoader($app['files'], $path);
        });

        $module_manager = $this->app->make('ModulesLoader');

        // Register Service Providers of all the active modules in a loop
        if(VaahSetup::isDBConnected() && VaahSetup::isDBMigrated()) {
            foreach ($module_manager->findModules() as $module) {

                $db_module = Module::where('slug', $module['slug'])->first();

                if (!$db_module) {
                    continue;
                }

                if ($db_module->is_active != 1) {
                    continue;
                }

                foreach ($module['providers'] as $provider) {
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
