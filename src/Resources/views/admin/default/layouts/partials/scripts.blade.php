@if(config('vaahcms.minified'))

    <script src="{{vh_get_admin_assets("assets/builds/vaahcms.js")}}" defer></script>

@else
    {!! vh_load_admin_js() !!}
@endif

