<?php namespace WebReinvent\VaahCms\Traits;

trait CrudObservantTrait
{
    public static function bootCrudObservantTrait()
    {
        static::observe(new \WebReinvent\VaahCms\Observers\CrudObserver());
    }
}