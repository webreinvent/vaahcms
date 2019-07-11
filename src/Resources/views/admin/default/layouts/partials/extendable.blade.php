<?php


$modules = new \WebReinvent\VaahCms\Entities\Module();

$all = $modules->all();

$module_order = [];
if($all->count() > 0)
{
    foreach($all as $item)
    {

        $settings_name = $view_file.'-order';



        $settings = $item->settings()->key($settings_name)->first();

        if($settings)
        {
            $module_order[$settings->value] = $item->slug;
        } else
        {
            $module_order[] = $item->slug;
        }
    }

    ksort($module_order);

    foreach($module_order as $module_slug)
    {
        $full_view_name = $module_slug.'::admin.extend.'.$view_file;
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