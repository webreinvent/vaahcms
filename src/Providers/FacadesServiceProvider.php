<?php

namespace WebReinvent\VaahCms\Providers;

use App;

use Illuminate\Support\ServiceProvider;
use WebReinvent\VaahCms\Entities\Module;
use WebReinvent\VaahCms\Libraries\VaahExcel;
use WebReinvent\VaahCms\Loaders\ModulesLoader;


class FacadesServiceProvider extends ServiceProvider
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

        App::bind('vaahexcel',function() {
            return new VaahExcel();
        });


    }

}
