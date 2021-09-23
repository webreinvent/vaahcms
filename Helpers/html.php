<?php

//--------------------------------------------------------------
function get_bootstrap_menu($menu, $parent_id = 0, $parents = array())
{



    $array = $menu['items'];

    if(!isset($menu['attr_id']) || is_null($menu['attr_id']) )
    {
        $menu['attr_id'] = \Str::slug($menu['name']);
    }

    if(!isset($menu['attr_class']) || is_null($menu['attr_class']) )
    {
        $menu['attr_class'] = 'navbar-expand-lg navbar-dark bg-dark';
    }

    if($parent_id==0)
    {
        foreach ($array as $element) {
            if (($element['parent_id'] != 0) && !in_array($element['parent_id'],$parents)) {
                $parents[] = $element['parent_id'];
            }
        }
    }

    $menu_html = '<nav class="navbar '.$menu['attr_class'].'" id="navbar-container-'.$menu['attr_id'].'">
    <div class="container">
        <a class="navbar-brand" href="'.url('/').'">'.$menu['name'].'</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse"
        data-target="#'.$menu['attr_id'].'"
        aria-controls="'.$menu['attr_id'].'" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="'.$menu['attr_id'].'"><ul class="navbar-nav ml-auto">';

    foreach($array as $element)
    {
        $link = $element['content']['link'];
        $active_class = "";
        if(isset($element['is_home']) && $element['is_home'] == 1 )
        {
            $link = url("/");
        }

        if(url()->current() === $link)
        {
            $active_class = 'active';
        }

        if($element['parent_id']==$parent_id)
        {
            if(in_array($element['id'],$parents))
            {
                $menu_html .= '<li class="nav-item dropdown">';
                $menu_html .= '<a href="'.$link.'"
                class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-expanded="false">'.$element['name'].'</a>';
            }
            else {
                $menu_html .= '<li  class="nav-item '.$active_class.'">';
                $menu_html .= '<a class="nav-link" href="'.$link.'">' . $element['name'] . '</a>';
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

    $menu_html .= '</ul></div></div></nav>';

    return $menu_html;


}
//--------------------------------------------------------------
function get_bulma_menu($menu, $parent_id = 0, $parents = array())
{

    $array = $menu['items'];

    if(!isset($menu['attr_id']) || is_null($menu['attr_id']) )
    {
        $menu['attr_id'] = \Str::slug($menu['name']);
    }

    if(!isset($menu['attr_class']) || is_null($menu['attr_class']) )
    {
        $menu['attr_class'] = 'navbar-expand-lg navbar-dark bg-dark';
    }

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
        $link = '';

        if($element['uri']){
            $link = $element['uri'];
        }

        if($element['content']){
            $link = $element['content']['link'];
        }

        $active_class = "";
        if(isset($element['is_home']) && $element['is_home'] == 1 )
        {
            $link = url("/");
        }

        if(url()->current() === $link)
        {
            $active_class = 'active';
        }

        if($element['parent_id']==$parent_id)
        {
            if(in_array($element['id'],$parents))
            {
                $menu_html .= '<div class="navbar-item has-dropdown is-hoverable">';
                $menu_html .= '<a class="navbar-link">'.$element['name'].'</a>';
            }
            else {
                $menu_html .= '<a class="navbar-item"';

                if($element['attr_target_blank']){
                    $menu_html .= 'target="_blank"';
                }

                $menu_html .= 'href="'.$link.'">' . $element['name'] . '</a>';
            }
            if(in_array($element['id'],$parents))
            {



                $menu_html .= '<div class="navbar-dropdown">';
                $menu_html .= get_bulma_menu($menu, $element['id'], $parents);
                $menu_html .= '</div></div>';
            }
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
