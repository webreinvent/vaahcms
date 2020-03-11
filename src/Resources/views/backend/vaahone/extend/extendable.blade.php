<?php


$modules = new \WebReinvent\VaahCms\Entities\Module();

$all = $modules->all();

$module_order = [];

$i = 0;
if($all->count() > 0)
{
    foreach($all as $item)
    {

        if(isset($view_file)){
            $settings_name = $view_file.'-order';
        }

        $settings = $item->settings()->key($settings_name)->first();

        if($settings && !is_null($settings->value) && $settings->value != "")
        {
            $module_order[$settings->value] = $item->slug;
        } else if($settings && !is_null($settings->id))
        {
            $module_order[$settings->id] = $item->slug;
        } else{
            $module_order[$i] = $item->slug;
        }

        $i++;
    }

    ksort($module_order);



    foreach($module_order as $module_slug)
    {
        $full_view_name = $module_slug.'::backend.extend.'.$view_file;
        if (\View::exists($full_view_name)) {
            try {
                $view = \View::make($full_view_name);

                echo $view;
            } catch (\Exception $e) {
                echo json_encode($e->getMessage());
            }
        }
    }

}



?>
