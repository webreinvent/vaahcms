
@if(config('vaahcms.minified'))

<link href="{{vh_get_admin_assets("assets/builds/vaahcms.css")}}" rel="stylesheet" media="screen">

@else

    {!! vh_load_admin_css() !!}

@endif