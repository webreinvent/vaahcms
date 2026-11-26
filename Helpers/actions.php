<?php

//-------------------------------------------------------------
use WebReinvent\VaahCms\Models\Module;
use WebReinvent\VaahCms\Models\Theme;

function vh_action_response($class_namespace, $method, $params=null) {
    try{
        $c = new $class_namespace($params);
        $response = $c->$method($params);
        return $response;
    } catch (\Throwable $e) {
        /*
         * F06 / R5.9 — widened from \Exception to \Throwable: an undefined
         * class (the realistic failure of a module still on PrimeVue 3)
         * raises \Error, which \Exception does not catch and which would
         * otherwise escape the hook and 500 the request. The returned shape
         * is unchanged.
         */
        $response['success'] = false;
        $response['errors'][] = $e->getMessage();
        return $response;
    }
}
//-------------------------------------------------------------
/**
 * F06 / R5.9 — the session key of the hook-failure collector.
 */
function vh_hook_failure_key()
{
    return 'vh_hook_failures';
}
//-------------------------------------------------------------
/**
 * F06 / R5.9 — read the collected hook failures as a map keyed by slug.
 *
 * Read-only: the collector is NOT forgotten on read — a failure the admin
 * has not yet seen must still be reported on the next load, and the
 * notification's own dismiss control (client-side, per session) is what
 * removes it.
 */
function vh_get_hook_failures()
{
    $key = vh_hook_failure_key();

    if(!session()->has($key))
    {
        return [];
    }

    $failures = (array) session()->get($key);

    $failed = [];
    foreach ($failures as $failure)
    {
        $slug = $failure['slug'];

        if(!isset($failed[$slug]))
        {
            $failed[$slug] = [
                'slug' => $slug,
                'source' => $failure['source'],
                'method' => $failure['method'],
                'methods' => [$failure['method']],
                'message' => $failure['message'],
                'time' => $failure['time'],
            ];
        } elseif(!in_array($failure['method'], $failed[$slug]['methods']))
        {
            // one slug, several failing hooks — keep every distinct method
            $failed[$slug]['methods'][] = $failure['method'];
        }
    }

    return $failed;
}
//-------------------------------------------------------------
/**
 * F06 / R5.9 — record one hook failure in the session collector and log it.
 *
 * One `Log::error` line per failure carries the three facts the admin
 * notification needs: slug, hook method and message (visible in
 * Advanced → Logs, which reads storage_path('logs')). Deduplicated on
 * slug+method+message so a reloaded page does not multiply entries.
 */
function vh_record_hook_failure($slug, $method, $failure, $source='module')
{
    $message = is_array($failure['errors'] ?? null)
        ? implode(' ', $failure['errors'])
        : ($failure['errors'] ?? '');

    $log_line = sprintf(
        'vaahcms hook failed: slug=%s source=%s method=%s message=%s',
        $slug,
        $source,
        $method,
        $message
    );

    /*
     * The store is real on a web request (started by the session middleware)
     * and empty-but-available in console contexts (queue workers, seeders),
     * where it degrades to per-process dedup. Log lines are de-duplicated
     * per failure, so a reloaded page never multiplies them.
     */
    $key = vh_hook_failure_key();
    $failures = session()->has($key) ? (array) session()->get($key) : [];

    foreach ($failures as $existing)
    {
        if($existing['slug'] === $slug
            && $existing['method'] === $method
            && $existing['message'] === $message)
        {
            // already reported — one log line per failure, not per request
            return;
        }
    }

    $failures[] = [
        'slug' => $slug,
        'source' => $source,
        'method' => $method,
        'message' => $message,
        'time' => now()->toIso8601String(),
    ];

    session()->put($key, $failures);

    // one Log::error line per failure (slug, method, message) — visible in
    // Advanced → Logs, which reads storage_path('logs')
    \Log::error($log_line);
}
//-------------------------------------------------------------
function vh_vaahcms_action($method, $params=null)
{
    $namespace = '\WebReinvent\VaahCms\Http\Controllers\ExtendController';
    $response = vh_action_response($namespace, $method, $params);
    return $response;
}
//-------------------------------------------------------------
//-------------------------------------------------------------
function vh_module_action($module_name, $action, $params=null, $section='backend'){

    $namespace = '\VaahCms\Modules\\'.$module_name;

    if($section=='backend')
    {
        $namespace .= '\Http\Controllers\Backend\\';
    } else{
        $namespace .= '\Http\Controllers\Frontend\\';
    }

    $action = explode('@', $action);

    $namespace .= $action[0];
    $method = $action[1];

    return vh_action_response($namespace, $method, $params);


}
//-------------------------------------------------------------
function vh_modules_action($method, $params=null, $output_type=null)
{

    $active_modules = Module::getActiveModules();


    if(count($active_modules) < 1)
    {
        return [];
    }

    $output['success'] = [];
    $output['failed'] = [];

    foreach ($active_modules as $item)
    {

        $res = vh_module_action($item->name, 'ExtendController@'.$method);


        if(isset($res['success']) && !$res['success'])
        {
            $output['failed'][$item->slug] = $res;

            // F06 / R5.9 — the failed map is unchanged; the same failure is
            // also recorded in the session collector (+ log line) so it is
            // visible in data.failed even when this hook ran on a request
            // that never serves the assets payload.
            vh_record_hook_failure($item->slug, $method, $res, 'module');

        } elseif(isset($res['success']) && $res['success']
            && isset($res['data']) && count(array_filter($res['data'])) > 0)
        {

            if($output_type == 'array'){

                if(isset($output['success']['data'])){
                    $output['success']['data'] = array_merge($output['success']['data'], $res['data']);
                }else{
                    $output['success']['data'] = $res['data'];
                }


            }else if($output_type == 'string'){
                $output['success']['data'] = $res['data'];
            }else if($output_type == 'concatenate_string'){
                $output['success']['data'] .= $res['data'];
            }
            else
            {
                $output['success'][$item->slug] = $res['data'];
            }
        }
    }

    return $output;

}

//-------------------------------------------------------------
function vh_theme_action($theme_name, $action, $params=null, $section='backend'){

    $namespace = '\VaahCms\Themes\\'.$theme_name;

    if($section=='backend')
    {
        $namespace .= '\Http\Controllers\Backend\\';
    } else{
        $namespace .= '\Http\Controllers\Frontend\\';
    }

    $action = explode('@', $action);

    $namespace .= $action[0];
    $method = $action[1];

    return vh_action_response($namespace, $method, $params);
}
//-------------------------------------------------------------

//-------------------------------------------------------------
function vh_themes_action($method, $params=null, $output_type=null)
{

    $themes = Theme::getActiveThemes();

    if(count($themes) < 1)
    {
        return [];
    }


    $output['success'] = [];
    $output['failed'] = [];

    foreach ($themes as $item)
    {
        $res = vh_theme_action($item->name, 'ExtendController@'.$method, $params);



        if(isset($res['success']) && !$res['success'])
        {
            $output['failed'][$item->slug] = $res;

            // F06 / R5.9 — same collector entry as the module branch.
            vh_record_hook_failure($item->slug, $method, $res, 'theme');

        } elseif(isset($res['success']) && $res['success']
            && isset($res['data']) && count(array_filter($res['data'])) > 0)
        {
            if($output_type == 'array'){
                $output['success']['data'][] = $res['data'];
            }else if($output_type == 'string'){
                $output['success']['data'] = $res['data'];
            }else if($output_type == 'concatenate_string'){
                $output['success']['data'] .= $res['data'];
            }
            else
            {
                $output['success'][$item->slug] = $res['data'];
            }
        }
    }

    return $output;

}
//-------------------------------------------------------------
function vh_action($method, $params=null, $output_type=null){

    $output['success'] = [];
    $output['failed'] = [];

    switch($output_type)
    {
        case 'array':


            $vaahcms_res = vh_vaahcms_action($method, $params);

            if(isset($vaahcms_res['success']) && !$vaahcms_res['success'])
            {
                $output['failed'] = $vaahcms_res;
            } else{
                $output['success'] = $vaahcms_res['data'];
            }

            $modules = vh_modules_action($method, $params, $output_type);

            if(isset($modules['success']) && count($modules['success']) > 0)
            {
                $output['success'] = array_merge($output['success'], $modules['success']['data']);
            }


            $themes = vh_themes_action($method, $params, $output_type);

            if(isset($themes['success']) &&  count($themes['success']) > 0)
            {
                $output['success'] = array_merge($output['success'], $themes['success']);
            }



            break;

        case 'string':

            $response = vh_vaahcms_action($method, $params);


            if(isset($response['success']) && $response['success'])
            {
                $params['string'] = $response['data'];
            }

            $response = vh_modules_action($method, $params, $output_type);

            if(isset($response['success']) && isset($response['data']))
            {
                $params['string'] = $response['data'];
            }

            $response = vh_themes_action($method, $output, $output_type);

            if(isset($response['success'])  && isset($response['data']))
            {
                $params['string'] = $response['data'];
            }

            $output = $params['string'];


            break;

        case 'concatenate_string':

            $output = vh_vaahcms_action($method, $params);
            $output .= vh_modules_action($method, $output, $output_type);
            $output .= vh_themes_action($method, $output, $output_type);

            break;

        default:
            $vaahcms_res = vh_vaahcms_action($method, $params);

            if(isset($vaahcms_res['success']) && !$vaahcms_res['success'])
            {
                $vaahcms['failed'] = $vaahcms_res;

                // F06 / R5.9 — core hook failures are collected under the
                // key `vaahcms`, same as module and theme failures.
                vh_record_hook_failure('vaahcms', $method, $vaahcms_res, 'vaahcms');
            } else{
                $vaahcms['success']['vaahcms'] = $vaahcms_res['data'];
            }

            $modules = vh_modules_action($method, $params, $output_type);
            $themes = vh_themes_action($method, $params, $output_type);

            $output = array_replace_recursive($vaahcms, $modules);
            $output = array_replace_recursive($output, $themes);

            break;
    }

    return $output;
}
//-------------------------------------------------------------
/*
 * $params = array('user_id', 'string');
 */
function vh_translate_dynamic_strings($string, $params=[])
{
    $params['string'] = $string;
    $output = vh_action('translateDynamicStrings', $params, 'string' );
    return $output;
}
//-------------------------------------------------------------
//-------------------------------------------------------------
//-------------------------------------------------------------
