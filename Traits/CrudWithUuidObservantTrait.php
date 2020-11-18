<?php namespace WebReinvent\VaahCms\Traits;

use WebReinvent\VaahCms\Observers\CrudWithUuidObserver;

trait CrudWithUuidObservantTrait
{
    public static function bootCrudWithUuidObservantTrait()
    {
        static::observe(new CrudWithUuidObserver());
    }
}