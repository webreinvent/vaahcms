@if(config('vaahcms.minified'))
    <script src="{{vh_get_admin_theme_url()}}/public{{ mix('vaahcms.js') }}" defer></script>
@else
    {!! vh_load_admin_js() !!}
@endif

