@extends("vaahcms::admin.default.layouts.dashboard")

@section('vaahcms_extend_admin_css')

@endsection


@section('vaahcms_extend_admin_js')
    <script src="{{vh_get_admin_assets("builds/app-dashboard.js")}}" defer></script>
@endsection

@section('content')

    <div id="vh-app-dashboard">

        <page-title></page-title>

        <router-view></router-view>


    </div>

    @include("vaahcms::admin.default.extend.dashboard")


@endsection
