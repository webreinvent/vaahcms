@extends("vaahcms::admin.default.layouts.app")

@section('vaahcms_extend_admin_css')

@endsection


@section('vaahcms_extend_admin_js')
    <script src="{{vh_get_admin_assets("builds/app-vaah.js")}}" defer></script>
@endsection

@section('content')

    <div id="vh-app-vaah">


        <top-menu></top-menu>
        <div class="content-body">
            <router-view></router-view>
        </div>


    </div>

@endsection
