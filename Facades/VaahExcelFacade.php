<?php
namespace WebReinvent\VaahCms\Facades;

/**
 *
 */

use Illuminate\Support\Facades\Facade;

class VaahExcelFacade extends Facade {

    protected static function getFacadeAccessor() {
        return 'vaahexcel';
    }

}
