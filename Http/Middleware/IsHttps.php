<?php

namespace WebReinvent\VaahCms\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use WebReinvent\VaahCms\Libraries\VaahSetup;

class IsHttps
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

        if(isset($_SERVER['HTTPS'])
            || $_SERVER['REQUEST_SCHEME'] === 'https'
            || $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https'
        )
        {
            \URL::forceScheme('https');
        }

        return $next($request);

    }
}
