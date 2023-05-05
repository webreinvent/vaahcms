<head>

    <title><?php if(isset($data->title)) { echo $data->title; } else {
            echo config('vaahcms.app_name')." v".config('vaahcms.version');
        } ?></title>

    <meta charset="UTF-8">

    <meta name=description content="">

    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" id="_token" content="{{ csrf_token() }}">

    <meta name="current-url" id="current_url" content="{{ url()->current() }}">
    <meta name="debug" id="debug" content="{{config('vaahcms.debug')}}">

    <base href="{{\URL::to('/')}}">

    <link href="https:/./fonts.googleapis.com/css?family=IBM+Plex+Sans:300,400,500,600,700&display=swap" rel="stylesheet">


    @if(env('VAAHCMS_ASSETS') == 'develop')
        <!--CSS Support for Bulma & Buefy-->
        <link href="http://localhost:4001/vaahone/css/build.css" rel="stylesheet" media="screen">
        <link href="http://localhost:4001/vaahone/css/style.css" rel="stylesheet" media="screen">

        <!--CSS Support for PrimeVue-->
        <link href="http://localhost:4001/vaahtwo/build/build.css" rel="stylesheet" media="screen">
    @else
        <!--CSS Support for Bulma & Buefy-->
        <link href="{{vh_get_backend_assets("css/build.css", 'vaahone')}}" rel="stylesheet" media="screen">
        <link href="{{vh_get_backend_assets("css/style.css", 'vaahone')}}" rel="stylesheet" media="screen">

        <!--CSS Support for PrimeVue-->
        <link href="{{vh_get_backend_assets("build/build.css", 'vaahtwo')}}" rel="stylesheet" media="screen">
    @endif


</head>
