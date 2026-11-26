<?php namespace WebReinvent\VaahCms;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use WebReinvent\VaahCms\Http\Middleware\SetLocale;
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
     * Bootstrap the application events.
     *
     * Bootstrap order contract (F05): the sequence below is a contract, not
     * an incidental ordering. In particular, registerGlobalSettings() must
     * precede registerRoutes(), because the route definitions and the Blade
     * layouts that read config('settings.global') (e.g. is_sidebar_collapsed)
     * observe a populated settings.global only when the global settings are
     * loaded first. Reordering these calls is a behaviour change.
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
        $router->pushMiddlewareToGroup('web', SetLocale::class);


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
     *
     */
    private function registerProviders() {

        //register module service provider
        $this->app->register(FacadesServiceProvider::class);

        $this->app->register(ThemesServiceProvider::class);
        $this->app->register(ModulesServiceProvider::class);

        $this->app->register(\Creativeorange\Gravatar\GravatarServiceProvider::class);

    }


    /**
     *
     */
    private function registerAlias() {

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();

        $loader->alias('VaahExcel', VaahExcelFacade::class);
        $loader->alias('VaahFile', VaahFileFacade::class);
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
            $global_settings = Setting::getGlobalConfigSettings();

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
     * Publishes the compiled admin SPA bundle, theme images and CSS under
     * the `assets` tag.
     *
     * Upgrade note (R6.2): publishing is opt-in, so an upgrade MUST re-publish
     * this tag (`php artisan vendor:publish --tag=assets --force`) or the
     * installation keeps serving the previously published, now stale, bundle.
     */
    private function registerAssets() {
        $this->publishes([__DIR__.'/Resources/assets' => public_path(config('vaahcms.build_directory_name','vaahcms'))], 'assets');
    }

    /**
     *
     * Registers the `migrations` tag ONLY — the package never auto-loads its
     * migrations (no framework migration autoloading call exists anywhere in
     * this package, as asserted by F05's "published, not auto-loaded" scenario),
     * so migration files enter the application exclusively through
     * `php artisan vendor:publish --tag=migrations`.
     *
     * Upgrade note (R6.2): an existing installation must run
     * `php artisan vendor:publish --tag=migrations --force` (or keep its
     * already-published copies) before `php artisan migrate --force`.
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
