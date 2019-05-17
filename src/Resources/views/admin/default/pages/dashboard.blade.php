@extends("vaahcms::admin.default.layouts.dashboard")

@section('vaahcms_extend_admin_css')

@endsection


@section('vaahcms_extend_admin_js')
    <script src="{{vh_get_admin_assets("assets/builds/app-dashboard.js")}}" defer></script>
@endsection

@section('content')

    <div id="app">



        <h1>Testing</h1>

        <router-view></router-view>


    </div>

@endsection