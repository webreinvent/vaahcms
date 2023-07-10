<?php namespace WebReinvent\VaahCms;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use WebReinvent\VaahCms\Models\Setting;
use WebReinvent\VaahCms\Facades\VaahExcelFacade;
use WebReinvent\VaahCms\Facades\VaahFileFacade;
use WebReinvent\VaahCms\Http\Middleware\IsHttps;
use WebReinvent\VaahCms\Libraries\VaahSetup;
use WebReinvent\VaahCms\Providers\FacadesServiceProvider;
use WebReinvent\VaahCms\Providers\ModulesServiceProvider;
use WebReinvent\VaahCms\Providers\ThemesServiceProvider;

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
    public function boot(Router $router) {



        $this->registerMiddleware($router);
        $this->registerConfigs();
        $this->registerGlobalSettings();
        $this->registerMigrations();
        $this->registerSeeders();
        $this->registerViews();
        $this->registerAssets();
        $this->registerTranslations();
        $this->registerRoutes();

    }


    /**
     *
     */
    public function register() {


        $this->registerProviders();
        $this->registerAlias();
        $this->registerHelpers();
        $this->registerLibraries();

    }



    /**
     *
     */
    private function registerMiddleware($router) {

        //global middleware
        $router->pushMiddlewareToGroup('web', IsHttps::class);


        //register middleware
        $router->aliasMiddleware('app.is.installed', \WebReinvent\VaahCms\Http\Middleware\IsInstalled::class);
        $router->aliasMiddleware('app.is.not.installed', \WebReinvent\VaahCms\Http\Middleware\IsNotInstalled::class);
        $router->aliasMiddleware('has.backend.access', \WebReinvent\VaahCms\Http\Middleware\HasBackendAccess::class);
        $router->aliasMiddleware('set.theme.details', \WebReinvent\VaahCms\Http\Middleware\SetThemeDetails::class);


    }



    /**
     *
     */
    private function registerHelpers() {

        //load all the helpers
        foreach (glob(__DIR__.'/Helpers/*.php') as $filename){
            require_once($filename);
        }

        foreach (glob(__DIR__.'/Mail/*.php') as $filename){
            require_once($filename);
        }

    }

    /**
     *
     */
    private function registerLibraries()
    {
        //load all the helpers
        foreach (glob(__DIR__.'/Libraries/*.php') as $filename){
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
    private function registerProviders() {

        //register module service provider
        $this->app->register(FacadesServiceProvider::class);

        $this->app->register(ThemesServiceProvider::class);
        $this->app->register(ModulesServiceProvider::class);

        $this->app->register(\ZanySoft\Zip\ZipServiceProvider::class,);
        $this->app->register(\Creativeorange\Gravatar\GravatarServiceProvider::class);

    }


    /**
     *
     */
    private function registerAlias() {

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();

        $loader->alias('VaahExcel', VaahExcelFacade::class);
        $loader->alias('VaahFile', VaahFileFacade::class);
        $loader->alias('Zip', \ZanySoft\Zip\ZipServiceProvider::class);
        $loader->alias('Carbon', \Carbon\Carbon::class);
        $loader->alias('Image', \Intervention\Image\Facades\Image::class);
        $loader->alias('Gravatar', 'Creativeorange\Gravatar\Facades\Gravatar');


    }

    /**
     *
     */
    private function registerConfigs() {

        $configPath = __DIR__ . '/Config/vaahcms.php';

        $this->publishes([$configPath => config_path('vaahcms.php')], 'config');

        $this->mergeConfigFrom($configPath, 'vaahcms');

        if(!config('vaahcms.get_config_version'))
        {
            $path =__DIR__ .'/composer.json';
            $config_data = json_decode(file_get_contents($path), true);
            config()->set('vaahcms.version', $config_data['version']);
        }

    }

    /**
     *
     */
    private function registerGlobalSettings() {

        if(VaahSetup::isInstalled() && !config('settings'))
        {
            $global_settings = Setting::where('category', 'global')
                ->get()
                ->pluck('value', 'key' )->toArray();

            config([
                'settings.global' => $global_settings
            ]);
        }

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
        $this->publishes([__DIR__.'/Resources/assets' => public_path('vaahcms')], 'assets');
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
    private function registerSeeders() {

        $this->publishes([__DIR__ . '/Database/Seeders' => database_path('seeds')], 'seeds');
    }

    /**
     *
     */
    private function registerRoutes() {

        include __DIR__.'/Routes/frontend.php';
        include __DIR__.'/Routes/backend.php';
        include __DIR__.'/Routes/api.php';

    }


}
