
    <meta charset="UTF-8">

    <meta name=description content="">

    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" id="_token" content="{{ csrf_token() }}">

    <meta name="current-url" id="current_url" content="{{ url()->current() }}">
    <meta name="debug" id="debug" content="{{config('vaahcms.debug')}}">
    <meta name="timezone" id="app_timezone" content="{{env('APP_TIMEZONE')??'UTC'}}">

    @if(env('SENTRY_DSN'))
        <meta name="sentry-dns" id="sentry_dns" content="{{env('SENTRY_DSN')}}">
    @endif

    <base href="{{\URL::to('/backend')}}">

    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:300,400,500,600,700&display=swap" rel="stylesheet">

    <link href="{{vh_get_backend_assets("fontawesome-6.2.0/css/all.min.css", 'common')}}" rel="stylesheet" media="screen">

    @if(env('VAAHCMS_ASSETS') == 'develop')
        <!--CSS Support for Bulma & Buefy-->
        <link href="http://localhost:4001/vaahone/css/build.css" rel="stylesheet" media="screen">
        <link href="http://localhost:4001/vaahone/css/style.css" rel="stylesheet" media="screen">

        <!--CSS Support for PrimeVue-->
        <link href="http://localhost:4001/vaahtwo/css/build.css" rel="stylesheet" media="screen">
    @else
        <!--CSS Support for Bulma & Buefy-->
        <link href="{{vh_get_backend_assets("css/build.css", 'vaahone')}}" rel="stylesheet" media="screen">
        <link href="{{vh_get_backend_assets("css/style.css", 'vaahone')}}" rel="stylesheet" media="screen">

        <!--CSS Support for PrimeVue-->
        <link href="{{vh_get_backend_assets("css/build.css", 'vaahtwo')}}" rel="stylesheet" media="screen">
    @endif

    {!! vh_config_css() !!}

    @yield('vaahcms_extend_backend_css')
