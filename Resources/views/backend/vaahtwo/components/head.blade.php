
    <meta charset="UTF-8">

    <meta name=description content="">

    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" id="_token" content="{{ csrf_token() }}">

    <meta name="current-url" id="current_url" content="{{ url()->current() }}">
    <meta name="debug" id="debug" content="{{config('vaahcms.debug')}}">
    <meta name="timezone" id="app_timezone" content="{{env('APP_TIMEZONE')??'UTC'}}">
    <meta name="{{str_to_slug(isset($title)?$title:'vaahcms')}}-version" id="{{str_to_slug(isset($title)?$title:'vaahcms')}}_verison" content="{{config('vaahcms.version')}}">

    {{-- M3-T1 (F09): pre-paint dark-mode resolution. Synchronous, before the
         stylesheet links, so no flash of the wrong scheme. The stored
         preference (vh_settings, via the assets payload key theme.dark_mode)
         wins; 'system' defers to the localStorage pre-paint cache
         vaah.dark-mode, then prefers-color-scheme. The class lives on
         <html> only (OpenVue theme options darkModeSelector '.app-dark'). --}}
    <script>
    (function () {
        var PREF = @json(vh_dark_mode_preference());
        var KEY = 'vaah.dark-mode';
        var preferences = ['light', 'dark', 'system'];
        var preference = preferences.indexOf(PREF) > -1 ? PREF : 'system';
        var cached = null;
        try { cached = window.localStorage.getItem(KEY); } catch (e) {}
        var dark;
        if (preference === 'dark') { dark = true; }
        else if (preference === 'light') { dark = false; }
        else if (cached === 'dark' || cached === 'light') { dark = cached === 'dark'; }
        else { dark = window.matchMedia('(prefers-color-scheme: dark)').matches; }
        document.documentElement.classList.toggle('app-dark', dark);
        try { window.localStorage.setItem(KEY, dark ? 'dark' : 'light'); } catch (e) {}
    })();
    </script>

    @if(env('SENTRY_DSN'))
        <meta name="sentry-dns" id="sentry_dns" content="{{env('SENTRY_DSN')}}">
    @endif

    <base href="{{\URL::to('/backend')}}">

    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:300,400,500,600,700&display=swap" rel="stylesheet">

    <link href="{{vh_get_backend_assets("fontawesome-6.2.0/css/all.min.css", 'common')}}" rel="stylesheet" media="screen">

    {{-- M3-T2 (F10) — single canonical OpenVue stylesheet (R4.9/R3.10): the
         two Laravel Mix outputs (the Mix-built stylesheets) and the Mix
         dev-server branch (VAAHCMS_ASSETS=develop → localhost:4001) are
         retired. Vite is the only build; the single Vite output carries
         the converged build.scss (PrimeFlex v4 + OpenIcons compat + the
         token-driven app layer). The legacy Bulma/Buefy `vaahone` theme is
         F32's to re-introduce (at most one link, under its own name) — it
         must never reintroduce the Mix build or a PrimeVue 3 stylesheet. --}}
    <link href="{{vh_get_backend_assets('build/index.css','vaahtwo')}}" rel="stylesheet" media="screen">

    {!! vh_config_css() !!}

    @yield('vaahcms_extend_backend_css')
