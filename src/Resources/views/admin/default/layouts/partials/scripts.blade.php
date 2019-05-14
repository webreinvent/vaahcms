@if(config('vaahcms.minified'))

    <script src="{{url("/")}}/public{{ mix('js/vaahcms-admin.js') }}" defer></script>

@else

    <script src="{{vh_get_admin_assets('lib/jquery/jquery.min.js')}}" defer></script>
    <script src="{{vh_get_admin_assets('lib/bootstrap/js/bootstrap.bundle.min.js')}}" defer></script>
    <script src="{{vh_get_admin_assets('lib/feather-icons/feather.min.js')}}" defer></script>
    <script src="{{vh_get_admin_assets('lib/perfect-scrollbar/perfect-scrollbar.min.js')}}" defer></script>

@endif

