<!DOCTYPE html>
<html lang="en">
<head>

    <title><?php if(isset($data->title)) { echo $data->title; } else {
            echo config('vaahcms.app_name')." v".config('vaahcms.version');
        } ?></title>

    <meta charset="UTF-8">

    <meta name=description content="">

    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" id="_token" content="{{ csrf_token() }}">

    <meta name="current-url" id="current_url" content="{{ url()->current() }}">
    <meta name="debug" id="debug" content="{{config('vaahcms.debug')}}">

    <base href="{{\URL::to('/')}}">

    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:300,400,500,600,700&display=swap" rel="stylesheet">


    @if(env('APP_VAAHCMS_ENV') == 'develop')
        <link href="http://localhost:8080/vaahone/css/build.css" rel="stylesheet" media="screen">
        <link href="http://localhost:8080/vaahone/css/style.css" rel="stylesheet" media="screen">
    @else
        <link href="{{vh_get_backend_assets("css/build.css")}}" rel="stylesheet" media="screen">
        <link href="{{vh_get_backend_assets("css/style.css")}}" rel="stylesheet" media="screen">
    @endif


</head>
<body class="@if(isset($data->body_class)){{$data->body_class}}@endif has-background-white-bis">

<!--sections-->
<section class="section">
    <div class="container has-text-centered ">

        <!--columns-->
        <div class="columns is-centered">
            <div class="column is-6">

                @include("vaahcms::backend.vaahone.components.errors")
                @include("vaahcms::backend.vaahone.components.flash")

                <h1 class="title" style="font-size: 5rem; margin-bottom: 3rem;">
                    <img src="{{url('/')}}/vaahcms/backend/vaahone/images/vaahcms-logo.svg">
                </h1>
                <p class="subtitle has-padding-top-10">
                    VaahCMS is a web application development platform shipped with
                    headless content management system.
                </p>


                <p>

                    <a href="{{route('vh.backend')}}" target="_blank"
                       class="button is-success is-link has-margin-top-10-mobile has-margin-right-10">Login</a>

                    <a href="https://vaah.dev/cms/docs"
                       target="_blank"
                       class="button is-link has-margin-top-10-mobile has-margin-right-10">Documentation</a>

                    <a href="https://github.com/webreinvent/vaahcms" target="_blank"
                       class="button has-margin-top-10-mobile is-dark">Github</a>


                </p>

            </div>
        </div>
        <!--/columns-->

    </div>
</section>
<!--sections-->


</body>
</html>
