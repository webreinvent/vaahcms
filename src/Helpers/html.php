<?php

//--------------------------------------------------------------
function get_bootstrap_menu($array, $parent_id = 0, $parents = array())
{
    if($parent_id==0)
    {
        foreach ($array as $element) {
            if (($element['parent_id'] != 0) && !in_array($element['parent_id'],$parents)) {
                $parents[] = $element['parent_id'];
            }
        }
    }
    $menu_html = '';
    foreach($array as $element)
    {
        if($element['parent_id']==$parent_id)
        {
            if(in_array($element['id'],$parents))
            {
                $menu_html .= '<li class="nav-item dropdown">';
                $menu_html .= '<a href="'.url()->route('vh.public.page', [$element['page']['slug']]).'" 
                class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" 
                                aria-expanded="false">'.$element['name'].'</a>';
            }
            else {
                $menu_html .= '<li  class="nav-item">';
                $menu_html .= '<a class="nav-link" href="'.url()->route('vh.public.page', [$element['page']['slug']]).'">' . $element['name'] . '</a>';
            }
            if(in_array($element['id'],$parents))
            {
                $menu_html .= '<ul class="dropdown-menu" role="menu">';
                $menu_html .= get_bootstrap_menu($array, $element['id'], $parents);
                $menu_html .= '</ul>';
            }
            $menu_html .= '</li>';
        }
    }
    return $menu_html;


}
//--------------------------------------------------------------
function get_ulli_menu($array, $parent_id = 0, $parents = array())
{
    if($parent_id==0)
    {
        foreach ($array as $element) {
            if (($element['parent_id'] != 0) && !in_array($element['parent_id'],$parents)) {
                $parents[] = $element['parent_id'];
            }
        }
    }
    $menu_html = '';
    foreach($array as $element)
    {
        if($element['parent_id']==$parent_id)
        {
            if(in_array($element['id'],$parents))
            {
                $menu_html .= '<li>';
                $menu_html .= '<a href="'.url()->route('vh.public.page', [$element['page']['slug']]).'">'.$element['name'].'</a>';
            }
            else {
                $menu_html .= '<li>';
                $menu_html .= '<a href="'.url()->route('vh.public.page', [$element['page']['slug']]).'">' . $element['name'] . '</a>';
            }
            if(in_array($element['id'],$parents))
            {
                $menu_html .= '<ul>';
                $menu_html .= get_ulli_menu($array, $element['id'], $parents);
                $menu_html .= '</ul>';
            }
            $menu_html .= '</li>';
        }
    }
    return $menu_html;


}
//--------------------------------------------------------------
//--------------------------------------------------------------
//--------------------------------------------------------------
//--------------------------------------------------------------