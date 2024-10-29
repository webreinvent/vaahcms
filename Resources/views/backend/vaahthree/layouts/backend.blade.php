<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php

            $title = config('vaahcms.app_name');

            if(config('settings.global.site_title')){
                $title = config('settings.global.site_title');
            }

            $version = config('vaahcms.version');

            if(env('VAAHCMS_VERSION')){
                $version = env('VAAHCMS_VERSION');
            }

           if(isset($data->title)) { echo $data->title; }
           else{
               echo $title." v".$version;
           }
           ?></title>
    @include("vaahcms::backend.vaahthree.components.head")

    {!! vh_config_css() !!}

</head>
<body class="{{config('settings.global.is_sidebar_collapsed') == null ||
    config('settings.global.is_sidebar_collapsed') ?'has-sidebar-small':''}}
    @if(isset($data->body_class)){{$data->body_class}}@endif">

<div>

    <div class="vaahthree">

        <div id="topmenu-sidebar" class="primevue"  >

            @include("vaahcms::backend.vaahthree.components.errors")
            @include("vaahcms::backend.vaahthree.components.flash")

            <div id="themeVaahThreeExtend"></div>

        </div>

        <div class="main-container">
            @yield('content')
        </div>

    </div>

</div>

{!! vh_config_js() !!}

@yield('vaahcms_extend_backend_js')

@if(env('VAAHCMS_VUE_APP') == 'develop')
    <script type="module" src="http://localhost:4000/mainExtended.js" defer></script>
@else
    <script type="module" src="{{vh_get_backend_assets("build/mainExtended.js", "vaahthree")}}" defer></script>
@endif

</body>
</html>

