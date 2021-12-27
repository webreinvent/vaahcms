<!DOCTYPE html>
<html lang="en">
<head>

    <title>
        <?php
        if(isset($data->title)) { echo $data->title; }
        elseif(env('VAAHCMS_VERSION')) {
            echo config('vaahcms.app_name')." v".env('VAAHCMS_VERSION');
        }else{
            echo config('vaahcms.app_name')." v".config('vaahcms.version');
        }
        ?>
    </title>

    <meta charset="UTF-8">

    <meta name=description content="">

    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" id="_token" content="{{ csrf_token() }}">

    <meta name="current-url" id="current_url" content="{{ url()->current() }}">
    <meta name="debug" id="debug" content="{{config('vaahcms.debug')}}">

    <base href="{{\URL::to('/')}}">

    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:300,400,500,600,700&display=swap" rel="stylesheet">


    @if(env('APP_VAAHCMS_ENV') == 'develop')
        <link href="http://localhost:8080/vaahone/css/build.css" rel="stylesheet" media="screen">
        <link href="http://localhost:8080/vaahone/css/style.css" rel="stylesheet" media="screen">
    @else
        <link href="{{vh_get_backend_assets("css/build.css")}}" rel="stylesheet" media="screen">
        <link href="{{vh_get_backend_assets("css/style.css")}}" rel="stylesheet" media="screen">
    @endif


    @yield('vaahcms_extend_backend_css')

</head>
<body class="@if(isset($data->body_class)){{$data->body_class}}@endif has-background-white-bis">

@include("vaahcms::backend.vaahone.components.errors")
@include("vaahcms::backend.vaahone.components.flash")


@yield('content')


@yield('vaahcms_extend_backend_js')

</body>
</html>
