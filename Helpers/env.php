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

//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------

