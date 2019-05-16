@extends("vaahcms::admin.default.layouts.dashboard")

@section('vaahcms_extend_admin_css')


@endsection


@section('vaahcms_extend_admin_js')

    <script src="{{url("/")}}/public{{ mix('js/app-dashboard.js') }}" defer></script>

@endsection

@section('content')

    <div id="app">

        @{{ test }}

        <h1>Testing</h1>

        <top-menu></top-menu>

    </div>

@endsection