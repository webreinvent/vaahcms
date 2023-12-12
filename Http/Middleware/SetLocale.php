<?php

namespace WebReinvent\VaahCms\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        if (config('settings.global.language')) {
            App::setLocale(config('settings.global.language'));
        }
        return $next($request);
    }
}
