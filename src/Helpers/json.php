<?php


//-----------------------------------------------------------------------------------
function vh_parse_json($json_file)
{

    $string      = file_get_contents($json_file);
    $string      = preg_split('/\n+/', $string);
    $returnArray = array();

    foreach ($string as $one) {
        if (preg_match('/^(#\s)/', $one) === 1 || preg_match('/^([\\n\\r]+)/', $one)) {
            continue;
        }
        $entry                  = explode("=", $one, 2);
        $returnArray[$entry[0]] = isset($entry[1]) ? $entry[1] : null;
    }

    return array_filter(
        $returnArray,
        function ($key) {
            return !empty($key);
        },
        ARRAY_FILTER_USE_KEY
    );

}
//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------

