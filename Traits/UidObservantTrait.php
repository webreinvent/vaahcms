<?php namespace WebReinvent\VaahCms\Traits;

use WebReinvent\VaahCms\Observers\UidObserver;

trait UidObservantTrait
{
    public static function bootCrudObservantTrait()
    {
        static::observe(new UidObserver());
    }
}