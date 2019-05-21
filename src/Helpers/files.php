<?php


//-----------------------------------------------------------------------------------



function vh_get_all_files($path, $ignored_files = array('.', '..', '.gitkeep'))
{
    $files = array_diff(scandir($path), $ignored_files);
    return $files;
}
//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------
function vh_create_folder($folder, $mode=0777, $recursive=true){
    mkdir($folder, $mode, $recursive);
}
//-----------------------------------------------------------------------------------
function vh_read_file($file){
    if(($handle = fopen($file, 'r')) == false)return false;
    if(($contents = fread($handle, filesize($file))) == false)return false;
    fclose($handle);
    return $contents;
}
//-----------------------------------------------------------------------------------
function vh_write_file($file, $contents, $flag='w+'){
    if(($handle = fopen($file, $flag)) == false)return false;
    if(fwrite($handle, $contents) == false)return false;
    return true;
}
//-----------------------------------------------------------------------------------
function vh_delete_file($path){
    if(is_file($path))unlink($path);
}
//-----------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------
function vh_delete_folder($path) {
    if (!file_exists($path)) {
        return true;
    }

    if (!is_dir($path)) {
        return unlink($path);
    }

    foreach (scandir($path) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!vh_delete_folder($path . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($path);
}
//-----------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------