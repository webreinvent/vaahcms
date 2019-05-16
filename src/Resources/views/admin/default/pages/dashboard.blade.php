@extends("vaahcms::admin.default.layouts.dashboard")

@section('vaahcms_extend_admin_css')

@endsection


@section('vaahcms_extend_admin_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-router/3.0.2/vue-router.js"></script>
    <script type="module" src="{{vh_get_admin_file("assets/vue/main.js")}}" defer></script>
@endsection

@section('content')

    <div id="app">



        <h1>Testing</h1>



    </div>

@endsection