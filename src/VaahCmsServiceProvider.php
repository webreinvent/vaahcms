<?php namespace WebReinvent\VaahCms;

use Illuminate\Support\ServiceProvider;
use WebReinvent\VaahCms\Providers\PluginManagerServiceProvider;

class VaahCmsServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {

        $this->handleConfigs();
        $this->handleMigrations();
        $this->handleViews();
        $this->handleTranslations();
        $this->handleRoutes();


    }

    //--------------------------------------------------------------



    //--------------------------------------------------------------


    public function register() {

        $this->app->register(PluginManagerServiceProvider::class);

        foreach (glob(__DIR__.'/Helpers/*.php') as $filename){
            require_once($filename);
        }

        //$this->app->register(BlogServiceProvider::class);

    }

    //--------------------------------------------------------------

    public function provides() {

        return [];
    }

    //--------------------------------------------------------------

    private function handleConfigs() {

        $configPath = __DIR__ . '/Config/vaahcms.php';

        $this->publishes([$configPath => config_path('vaahcms.php')], 'config');

        $this->mergeConfigFrom($configPath, 'vaahcms');
    }

    //--------------------------------------------------------------

    private function handleTranslations() {

        $this->loadTranslationsFrom(__DIR__.'/Resources/lang', 'vaahcms');
    }

    //--------------------------------------------------------------

    private function handleViews() {

        $this->loadViewsFrom(__DIR__.'/Resources/views', 'vaahcms');

        $this->publishes([__DIR__.'/Resources/views' => base_path('resources/views/vendor/vaahcms')], 'views');
    }

    //--------------------------------------------------------------

    private function handleMigrations() {

        $this->publishes([__DIR__ . '/Database/Migrations' => database_path('migrations')], 'migrations');
    }

    //--------------------------------------------------------------

    private function handleRoutes() {

        include __DIR__.'/Routes/web.php';
        include __DIR__.'/Routes/api.php';

    }

    //--------------------------------------------------------------

    //--------------------------------------------------------------
    //--------------------------------------------------------------
}
