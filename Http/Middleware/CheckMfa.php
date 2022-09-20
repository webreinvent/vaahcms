<?php

namespace WebReinvent\VaahCms\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use WebReinvent\VaahCms\Entities\Theme;

class CheckMfa
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
        if(auth()->check()){

            $user = auth()->user();

            if($user->mfa_code)
            {

                if($user->mfa_code_expired_at->lt(now()))
                {
                    auth()->logout();

                    return redirect()->route('vh.backend');
                }

                if(config('settings.global.is_mfa_enabled') == 1){

                    if(config('settings.global.mfa_enable_type') == 'all-users'){

                        return redirect()->route('vh.backend').'#/verify';
                    }

                    if(config('settings.global.mfa_enable_type') == 'user-will-have-option'
                        && Auth::user()->is_mfa_enabled){
                        return redirect()->route('vh.backend');
                    }

                }


            }


        }



        return $next($request);

    }
}
