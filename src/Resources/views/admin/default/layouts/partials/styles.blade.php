
@if(config('vaahcms.minified'))

    <link href="{{vh_get_admin_theme_url()}}/public{{ mix('vaahcms.css') }}" rel="stylesheet" media="screen">

@else

    {!! vh_load_admin_css() !!}

@endif