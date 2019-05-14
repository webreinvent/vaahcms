@if(config('vaahcms.minified'))

    <script src="{{url("/")}}/public{{ mix('js/vaahcms-admin.js') }}" defer></script>

@else


@endif

