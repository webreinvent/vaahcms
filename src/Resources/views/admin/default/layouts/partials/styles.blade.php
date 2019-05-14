
@if(config('vaahcms.minified'))

    <link href="{{url("/")}}/public{{ mix('css/vaahcms-admin.css') }}" rel="stylesheet" media="screen">

@else

    {{vh_load_admin_css()}}

    <link href="{{vh_get_admin_assets('lib/fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet" media="screen">
    <link href="{{vh_get_admin_assets('lib/ionicons/css/ionicons.min.css')}}" rel="stylesheet" media="screen">
    <link href="{{vh_get_admin_css('style.css')}}" rel="stylesheet" media="screen">

@endif