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
        <link href="http://localhost:8080/vaahone/css/vaahcms.css" rel="stylesheet" media="screen">
        <link href="http://localhost:8080/vaahone/css/backend.css" rel="stylesheet" media="screen">
    @else
        <link href="{{vh_get_backend_assets("css/vaahcms.css")}}" rel="stylesheet" media="screen">
        <link href="{{vh_get_backend_assets("css/backend.css")}}" rel="stylesheet" media="screen">
    @endif


</head>
<body class="@if(isset($data->body_class)){{$data->body_class}}@endif has-background-white-bis">

<nav class="navbar">
    <div class="container">
        <div id="navMenu" class="navbar-menu">
            <div class="navbar-start">
                <a href="{{url("/")}}" class="navbar-item">
                    Home
                </a>

            </div>

            <div class="navbar-end">
                <div class="navbar-item">

                    <div class="buttons">
                        <a href="https://vaah.dev/cms/docs"
                           target="_blank"
                           class="button is-link">Documentation</a>

                        <a href="https://github.com/webreinvent/vaahcms" target="_blank"
                           class="button is-dark">Github</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!--sections-->
<section class="hero  is-fullheight-with-navbar">
    <div class="hero-body">

        <!--container-->
        <div class="container  has-text-centered" style="margin-bottom: 250px;">

            <div class="columns">

                <div class="column is-half is-offset-one-quarter">
                    @include("vaahcms::backend.vaahone.components.errors")
                    @include("vaahcms::backend.vaahone.components.flash")
                </div>

            </div>


            <h1 class="title" style="font-size: 7rem; margin-bottom: 4rem;">
                VaahCMS
            </h1>
            <h2 class="subtitle" style="font-size: 3rem; font-weight: 200;">
                Develop enterprise web applications.
            </h2>



        </div>
        <!--/container-->


    </div>
</section>
<!--sections-->


</body>
</html>
