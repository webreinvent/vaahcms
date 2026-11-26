<?php namespace WebReinvent\VaahCms\Traits;

trait CrudObservantTrait
{
    public static function bootCrudObservantTrait()
    {
        // Laravel 13 throws a LogicException when a model is instantiated while its
        // class is being booted, and Model::observe() instantiates `new static`.
        // Registering through whenBooted() keeps the same observer semantics
        // (same observer class, same model events) with identical timing — the
        // registration still happens during the first instantiation — without a
        // nested instantiation inside boot().
        static::whenBooted(function () {
            static::observe(new \WebReinvent\VaahCms\Observers\CrudObserver());
        });
    }
}