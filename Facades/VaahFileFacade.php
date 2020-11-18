<?php
namespace WebReinvent\VaahCms\Facades;

use Illuminate\Support\Facades\Facade;

class VaahFileFacade extends Facade {

    protected static function getFacadeAccessor() {
        return 'vaahfile';
    }

}
