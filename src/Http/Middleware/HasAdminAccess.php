<?php

namespace WebReinvent\VaahCms\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasAdminAccess
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

        //check user is logged in
        if (Auth::guest())
        {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {

                $url = url()->full();

                session(['accessed_url' => $url]);

                return \Redirect::back()
                    ->withErrors([trans("vaahcms::messages.login_required")]);
            }
        }

        if(Auth::user()->is_active != 1)
        {
            return \Redirect::back()
                ->withErrors([trans("vaahcms::messages.inactive_account")]);
        }


        $check_permission = Auth::user()->hasPermission("can-access-admin-section");

        //check user have permission to back login
        if($check_permission['status'] == 'failed')
        {

            return \Redirect::back()
                ->withErrors($check_permission['errors']);
        }


        return $next($request);
    }
}
