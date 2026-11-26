<?php namespace WebReinvent\VaahCms\Traits;

use WebReinvent\VaahCms\Observers\UidObserver;

trait UidObservantTrait
{
    public static function bootCrudObservantTrait()
    {
        // Same Laravel 13 boot-compatibility fix as the sibling traits:
        // Model::observe() instantiates `new static`, which Laravel 13 rejects
        // while a class is being booted. whenBooted() defers registration to the
        // end of boot with identical semantics. (Pre-existing quirk preserved:
        // this method name does not match the trait name, so bootTraits() does
        // not invoke it for classes using only this trait.)
        static::whenBooted(function () {
            static::observe(new UidObserver());
        });
    }
}