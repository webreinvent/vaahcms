<?php
namespace WebReinvent\VaahCmsCore;
use Illuminate\Support\Facades\Facade;


class VaahCmsCoreFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'vaahcmscore';
    }
}
