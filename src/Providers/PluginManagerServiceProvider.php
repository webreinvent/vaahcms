<?php

namespace WebReinvent\VaahCms\Providers;

use Illuminate\Support\ServiceProvider;
use WebReinvent\VaahCms\Plugins\PluginLoader;

class PluginManagerServiceProvider extends ServiceProvider
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

        $this->app->singleton('PluginLoader', function($app)
        {
            return new PluginLoader($app['files'], base_path('Plugins'));
        });

        $pluginManager = $this->app->make('PluginLoader');

        // Register other plugin Service Providers in a loop here?
        foreach ($pluginManager->findPlugins() as $plugin)
        {
            if(!isset($plugin['active']) || $plugin['active'] != 1 )
            {
                continue;
            }

            foreach ($plugin['providers'] as $provider)
            {
                $this->app->register($provider);
            }
        }

    }
}
