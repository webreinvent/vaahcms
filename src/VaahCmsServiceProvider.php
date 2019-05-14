<?php namespace WebReinvent\VaahCms;

use Illuminate\Support\ServiceProvider;
use WebReinvent\VaahCms\Providers\ModulesServiceProvider;

/**
 * Class VaahCmsServiceProvider
 * @package WebReinvent\VaahCms
 */
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

        $this->registerConfigs();
        $this->registerMigrations();
        $this->registerViews();
        $this->registerAssets();
        $this->registerTranslations();
        $this->registerRoutes();

    }


    /**
     *
     */
    public function register() {

        $this->registerConfigs();

        //register module service provider
        $this->app->register(ModulesServiceProvider::class);

        //load all the helpers
        foreach (glob(__DIR__.'/Helpers/*.php') as $filename){
            require_once($filename);
        }

    }


    /**
     * @return array
     */
    public function provides() {

        return [];
    }


    /**
     *
     */
    private function registerConfigs() {


        $configPath = __DIR__ . '/Config/vaahcms.php';

        $this->publishes([$configPath => config_path('vaahcms.php')], 'config');

        $this->mergeConfigFrom($configPath, 'vaahcms');

    }

    /**
     *
     */
    private function registerTranslations() {

        $path = __DIR__.'/Resources/lang';

        $this->loadTranslationsFrom($path, 'vaahcms');

        $this->publishes([$path => base_path('resources/lang/vendor/vaahcms')], 'lang');
    }

    /**
     *
     */
    private function registerViews() {

        $this->loadViewsFrom(__DIR__.'/Resources/views', 'vaahcms');
        $this->publishes([__DIR__.'/Resources/views' => base_path('resources/views/vendor/vaahcms')], 'views');

    }

    /**
     *
     */
    private function registerAssets() {

        $this->publishes([__DIR__.'/Resources/assets' => base_path('resources/assets/vendor/vaahcms')], 'assets');

    }

    /**
     *
     */
    private function registerMigrations() {

        $this->publishes([__DIR__ . '/Database/Migrations' => database_path('migrations')], 'migrations');
    }


    /**
     *
     */
    private function registerRoutes() {

        include __DIR__.'/Routes/admin.php';
        include __DIR__.'/Routes/public.php';
        include __DIR__.'/Routes/api.php';

    }


}
