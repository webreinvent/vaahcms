@extends("vaahcms::admin.default.layouts.dashboard")

@section('vaahcms_extend_admin_css')

@endsection


@section('vaahcms_extend_admin_js')
    <script src="{{vh_get_admin_file("assets/vue-builds/dashboard.js")}}" defer></script>
@endsection

@section('content')

    <div id="app">

        @{{ url }}

        <h1>Testing</h1>

        <top-menu></top-menu>

    </div>

@endsection