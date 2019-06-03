@extends("vaahcms::admin.default.layouts.dashboard")

@section('vaahcms_extend_admin_css')

@endsection


@section('vaahcms_extend_admin_js')

@endsection

@section('content')

    <div id="vh-app-registrations">



        <!--content-->

        <div class="row">

            <registrations></registrations>

            <router-view :urls="urls"></router-view>


        </div>
        <!--/content-->


    </div>

@endsection
