<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php
           if(isset($data->title)) { echo $data->title; }
           elseif(env('VAAHCMS_VERSION')) {
               echo config('vaahcms.app_name')." v".env('VAAHCMS_VERSION');
           }else{
               echo config('vaahcms.app_name')." v".config('vaahcms.version');
           }
           ?></title>
    @include("vaahcms::backend.vaahtwo.components.head")

    {!! vh_config_css() !!}

    @yield('vaahcms_extend_backend_css')

</head>

<body class="vaahtwo primevue @if(isset($data->body_class)){{$data->body_class}}@endif">

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
