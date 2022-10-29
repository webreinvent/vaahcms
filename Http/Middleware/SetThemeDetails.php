<?php

namespace WebReinvent\VaahCms\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use WebReinvent\VaahCms\Entities\Theme;

class SetThemeDetails
{
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|\stdClass
     */
    private mixed $theme_slug;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $theme_slug = vh_get_theme_from_slug();

        \Session::put('theme_slug', $theme_slug);

        //for controllers
        $request->merge([ 'theme_slug' => $theme_slug ]);

        //for view
        \View::share('theme_slug', $theme_slug);

        return $next($request);
    }
}
