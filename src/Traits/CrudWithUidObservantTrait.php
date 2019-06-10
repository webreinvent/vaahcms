<?php namespace WebReinvent\VaahCms\Traits;

use WebReinvent\VaahCms\Observers\CrudWithUidObserver;

trait CrudWithUidObservantTrait
{
    public static function bootCrudWithUidObservantTrait()
    {
        static::observe(new CrudWithUidObserver());
    }
}