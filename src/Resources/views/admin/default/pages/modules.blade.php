@extends("vaahcms::admin.default.layouts.dashboard")

@section('vaahcms_extend_admin_css')

@endsection


@section('vaahcms_extend_admin_js')
    <script src="{{vh_get_admin_assets("builds/app-modules.js")}}" defer></script>
@endsection

@section('content')

    <div id="vh-app-modules">







        <router-view :urls="urls"></router-view>






    </div>

@endsection
