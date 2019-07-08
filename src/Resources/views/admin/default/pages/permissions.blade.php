@extends("vaahcms::admin.default.layouts.dashboard")

@section('vaahcms_extend_admin_css')

@endsection


@section('vaahcms_extend_admin_js')
    <script src="{{vh_get_admin_assets("builds/app-permissions.js")}}" defer></script>
@endsection

@section('content')

    <div id="vh-app-permissions">


        <!--content-->
        <div class="row">

            <list :urls="urls" :assets="assets"></list>

            <router-view :urls="urls" :assets="assets"></router-view>

        </div>
        <!--/content-->


    </div>

@endsection
