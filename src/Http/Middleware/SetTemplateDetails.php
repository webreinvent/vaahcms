<?php

namespace WebReinvent\VaahCms\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use VaahCms\Modules\Cms\Entities\Page;
use WebReinvent\VaahCms\Entities\Theme;

class SetTemplateDetails
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

        //for controller
        $request->template_slug = config('vaahcms.public_theme_template');

        //for view
        \View::share('template_slug', $request->template_slug);

        $page_slug = $request->slug;

        $page = Page::where('slug', $page_slug)
            ->with(['template'])
            ->first();

    	if($page)
        {

            //for controller
            $request->template_slug = $page->template->slug;
            $request->template = $page->template;
            $request->page = $page;

            \Session::put('template', $page->template);
            \Session::put('page', $page);

            //for view
            \View::share('template_slug', $page->template->slug);
            \View::share('template', $page->template);
            \View::share('page', $page);

        }

        return $next($request);
    }
}
