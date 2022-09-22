<?php

namespace WebReinvent\VaahCms\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use WebReinvent\VaahCms\Entities\Theme;

class VerifyAuth
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

        dd($request);

        if(auth()->check()){

            $user = auth()->user();


            if($user->mfa_code)
            {

                if($user->mfa_code_expired_at->lt(now()))
                {

                    auth()->logout();

                    return redirect()->route('vh.backend');
                }

                if(config('settings.global.mfa_status') !== 'disable'){

                    if(config('settings.global.mfa_status') == 'all-users'){

                        auth()->logout();

                        return redirect()->route('vh.backend');
                    }

                    if(config('settings.global.mfa_status') == 'user-will-have-option'
                        && is_array($user->mfa_methods) && count($user->mfa_methods) >= 0){

                        auth()->logout();

                        return redirect()->route('vh.backend');

                    }

                }

            }

        }

        return $next($request);

    }
}
