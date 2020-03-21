@extends("vaahcms::backend.vaahone.layouts.default")

@section('vaahcms_extend_backend_css')

@endsection


@section('vaahcms_extend_backend_js')

@endsection

@section('content')

    <div id="app">

        <router-view></router-view>

        <vue-progress-bar></vue-progress-bar>

    </div>



@endsection
