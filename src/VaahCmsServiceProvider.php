<?php namespace WebReinvent\VaahCms;

use Illuminate\Support\ServiceProvider;
use WebReinvent\VaahCms\Providers\ModulesServiceProvider;

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

        $this->handleConfigs();

        //register module service provider
        $this->app->register(ModulesServiceProvider::class);

        //load all the helpers
        foreach (glob(__DIR__.'/Helpers/*.php') as $filename){
            require_once($filename);
        }

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

        $path = __DIR__.'/Resources/lang';

        $this->loadTranslationsFrom($path, 'vaahcms');

        $this->publishes([$path => base_path('resources/views/vendor/vaahcms/lang')], 'lang');
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

        include __DIR__.'/Routes/admin.php';
        include __DIR__.'/Routes/public.php';
        include __DIR__.'/Routes/api.php';

    }

    //--------------------------------------------------------------

    //--------------------------------------------------------------
    //--------------------------------------------------------------
}
