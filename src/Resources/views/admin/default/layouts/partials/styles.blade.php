
@if(config('vaahcms.minified'))

    <link href="{{url("/")}}/public{{ mix('css/vaahcms-admin.css') }}" rel="stylesheet" media="screen">

@else

    {!! vh_load_admin_css() !!}

@endif