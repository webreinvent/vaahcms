<?php

//-----------------------------------------------------------------------------------

function vh_search_engine_visibility()
{
    $value = null;
    if(config('settings.global.search_engine_visibility')){
        $value = "<meta name=\"robots\" content=\"noindex\" />";
    }
    return $value;
}
//-----------------------------------------------------------------------------------

// M3-T1 (F09) — the signed-in user's dark-mode preference
// (vh_settings: category='user_setting', key='dark_mode') for the Blade
// layouts' server-rendered <html class="app-dark">. 'light'|'dark'|'system',
// or null for guests / no row yet (the SPA defaults to 'system').
function vh_dark_mode_preference()
{
    if(!\Auth::check())
    {
        return null;
    }

    // Called twice per authenticated page render (the <html> class and the
    // pre-paint @json in head). Two indexed lookups per render is deliberate:
    // caching here (static or container-bound) would go stale on
    // impersonation switches and across the test request cycle, for no
    // measurable gain on a row-scoped lookup.
    $setting = \WebReinvent\VaahCms\Models\Setting::where('category', 'user_setting')
        ->where('key', 'dark_mode')
        ->where('vh_user_id', \Auth::id())
        ->first();

    if($setting && in_array($setting->value, ['light', 'dark', 'system'], true))
    {
        return $setting->value;
    }

    return null;
}
//-----------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------
