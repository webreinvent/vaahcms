<?php

namespace WebReinvent\VaahCms\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use WebReinvent\VaahCms\Entities\Theme;

class SetThemeDetails
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

    	$theme_slug = config('vaahcms.public_theme');

        //for controller
        $request->theme_slug = $theme_slug;

        //for view
        \View::share('theme_slug', $theme_slug);

    	$active_theme = Theme::active()->first();

    	if($active_theme)
        {

            //for controller
            $request->theme_slug = $active_theme->slug;
            $request->theme = $active_theme;

            \Session::put('theme', $active_theme);


            //for view
            \View::share('theme_slug', $active_theme->slug);
            \View::share('theme', $active_theme);

        }

        return $next($request);
    }
}
