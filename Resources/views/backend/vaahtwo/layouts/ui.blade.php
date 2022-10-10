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

</head>

<body class="vaahtwo primevue @if(isset($data->body_class)){{$data->body_class}}@endif">

    @include("vaahcms::backend.vaahtwo.components.errors")
    @include("vaahcms::backend.vaahtwo.components.flash")

    <div id="themeAppVaahTwo">

    </div>

    @yield('content')


    {!! vh_config_js() !!}

    @yield('vaahcms_extend_backend_js')


    @if(env('APP_VAAHCMS_ENV') == 'develop')
        <script type="module" src="http://localhost:2323/main.js" defer></script>
    @else
        <script type="module" src="{{vh_get_backend_assets("builds/index.js", "vaahprime")}}" defer></script>
    @endif



</body>
</html>
