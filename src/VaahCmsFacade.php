<?php
namespace WebReinvent\VaahCms;
use Illuminate\Support\Facades\Facade;


class VaahCmsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'vaahcms';
    }
}
