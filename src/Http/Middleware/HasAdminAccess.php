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

			    return redirect()->guest(route('vh.admin.login'))
				    ->withErrors([trans("vaahcms::messages.login_required")]);
		    }
	    }

	    if(Auth::user()->is_active != 1)
	    {
		    return redirect()->guest(route('vh.admin.login'))
		                     ->withErrors([trans("vaahcms::messages.inactive_account")]);
	    }

	    //check user have permission to back login
	    if(!Auth::user()->hasPermission("vaahcms#admin#access"))
	    {
		    return redirect()->guest(route('vh.admin.login'))
		                     ->withErrors([trans("vaahcms::messages.permission_denied")]);
	    }


        return $next($request);
    }
}
