@extends("vaahcms::backend.vaahone.layouts.default")

@section('vaahcms_extend_backend_css')

@endsection


@section('vaahcms_extend_backend_js')

    @if(env('APP_VAAHCMS_ENV') == 'develop')
        <script src="http://localhost:8080/vaahone/builds/app.js" defer></script>
    @else
        <script src="{{vh_get_backend_assets("builds/app.js")}}" defer></script>
    @endif

@endsection

@section('content')

    <div id="app">

        <router-view></router-view>

        <vue-progress-bar></vue-progress-bar>

    </div>



@endsection
