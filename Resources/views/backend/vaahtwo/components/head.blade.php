
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

    <base href="{{\URL::to('/')}}">

    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:300,400,500,600,700&display=swap" rel="stylesheet">

    @if(env('APP_VAAHCMS_ENV') != 'develop')
        <link href="{{vh_get_backend_assets("builds/index.css", 'vaahprime')}}" rel="stylesheet" media="screen">
    @endif

    {!! vh_config_css() !!}

    @yield('vaahcms_extend_backend_css')
