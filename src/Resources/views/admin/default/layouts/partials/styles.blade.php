
@if(config('vaahcms.minified'))

    <link href="{{url("/")}}/public{{ mix('css/vaahcms-admin.css') }}" rel="stylesheet" media="screen">

@else

    <link href="{{vh_get_admin_css('dashforge.css')}}" rel="stylesheet" media="screen">

@endif