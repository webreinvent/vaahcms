<?php


//-----------------------------------------------------------------------------------
function vh_env_file_to_array($file, $key_lower=false)
{

    $string      = file_get_contents($file);
    $string      = preg_split('/\n+/', $string);
    $returnArray = array();

    foreach ($string as $one) {
        if (preg_match('/^(#\s)/', $one) === 1 || preg_match('/^([\\n\\r]+)/', $one)) {
            continue;
        }
        $entry                  = explode("=", $one, 2);
        $returnArray[$entry[0]] = isset($entry[1]) ? $entry[1] : null;
    }

    $list = array_filter(
        $returnArray,
        function ($key) {
            return !empty($key);
        },
        ARRAY_FILTER_USE_KEY
    );

    $result = [];
    foreach ($list as $key => $value)
    {
        if($key_lower)
        {
            $key = strtolower($key);
        }

        $result[$key] = $value;
    }

    return $result;

}
//-----------------------------------------------------------------------------------
function vh_env_string($string = '')
{

    if($string && str_contain($string)){
        return '"'.$string.'"';
    }

    return $string;

}
//-----------------------------------------------------------------------------------
// R2.3 / architecture.md §9 — Laravel 13 changed the default cache / Redis / session
// prefixes, so `CACHE_PREFIX`, `REDIS_PREFIX` and `SESSION_COOKIE` have to be set
// EXPLICITLY in `.env` to retain the pre-13 namespaces; `.env.example` carries the
// canonical values.
//
// The setup wizard writes `.env` from `templates/env.blade.php`, and that template
// used to write `strtolower(APP_NAME)` for all three. Installing therefore silently
// reverted the retention the upgrade relies on: every cache key and Redis key is
// orphaned under a new namespace, and the session cookie is renamed, so every user
// is logged out. The wizard is a first-class way to write `.env`, so it has to write
// the retained namespaces too.
//
// The value already present in the environment file wins, so re-installing never
// moves a namespace an operator has already chosen; the canonical default is used
// only when there is nothing to preserve.
function vh_l13_namespace($key, $default)
{
    $files = ['.env'];

    try{
        $active = \WebReinvent\VaahCms\Libraries\VaahSetup::getActiveEnvFileName();
        if($active && !in_array($active, $files)) {
            $files[] = $active;
        }
    }catch(\Throwable $e){
        // no vaahcms.json yet — `.env` is the only candidate
    }

    foreach($files as $file) {
        $path = base_path($file);
        if(!file_exists($path)) {
            continue;
        }
        $list = vh_env_file_to_array($path);
        if(isset($list[$key])) {
            $value = trim((string)$list[$key]);
            $value = trim($value, "\"'");
            if($value !== '') {
                return $value;
            }
        }
    }

    return $default;
}
//-----------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------

