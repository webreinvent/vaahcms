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
    @include("vaahcms::backend.vaahtwo.components.head",['title' => $title])

    {!! vh_config_css() !!}

    @yield('vaahcms_extend_backend_css')

</head>

<body class="vaahtwo primevue {{config('settings.global.is_sidebar_collapsed') == null ||
    config('settings.global.is_sidebar_collapsed') ?'has-sidebar-small':''}}
    @if(isset($data->body_class)){{$data->body_class}}@endif">

@include("vaahcms::backend.vaahtwo.components.errors")
@include("vaahcms::backend.vaahtwo.components.flash")

    <!--vaahtwo app-->
    <div id="themeVaahTwo"></div>
    <!--/vaahtwo app-->

@yield('content')

{!! vh_config_js() !!}

@yield('vaahcms_extend_backend_js')

@if(env('VAAHCMS_VUE_APP') == 'develop')
    <script type="module" src="http://localhost:4000/main.js" defer></script>
@else
    <script type="module" src="{{vh_get_backend_assets("build/main.js", "vaahtwo")}}" defer></script>
@endif

</body>
</html>
