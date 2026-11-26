<?php namespace WebReinvent\VaahCms\Traits;

use WebReinvent\VaahCms\Observers\CrudWithUidObserver;

trait CrudWithUidObservantTrait
{
    public static function bootCrudWithUidObservantTrait()
    {
        // Same Laravel 13 boot-compatibility fix as CrudWithUuidObservantTrait:
        // Model::observe() instantiates `new static`, which Laravel 13 rejects
        // while a class is being booted. whenBooted() defers registration to the
        // end of boot with identical semantics.
        static::whenBooted(function () {
            static::observe(new CrudWithUidObserver());
        });
    }
}