<?php

namespace WebReinvent\VaahCms\Providers;

use App;

use Illuminate\Support\ServiceProvider;
use WebReinvent\VaahCms\Libraries\VaahExcel;
use WebReinvent\VaahCms\Libraries\VaahFile;



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

        App::bind('vaahfile',function() {
            return new VaahFile();
        });

    }

}
