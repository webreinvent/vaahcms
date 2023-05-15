@extends("vaahcms::frontend.layouts.simple")

@section('content')
    <div class="grid mt-5">
        <div class="col-6 col-offset-3 text-center ">

            @include("vaahcms::frontend.partials.errors")
            @include("vaahcms::frontend.partials.flash")

            <h1 class="title mb-1">
                <img src="{{url('/')}}/vaahcms/backend/vaahone/images/vaahcms-logo.svg">
            </h1>
            <p class="mb-5">
                <b>VaahCMS</b> is a web application development platform shipped with
                headless content management system.
            </p>


            <p>

                @if(\WebReinvent\VaahCms\Libraries\VaahSetup::isInstalled())
                    <a href="{{route('vh.backend')}}" target="_blank"
                       class="p-button p-component p-button-sm no-underline" >
                        <span class="p-button-label">Login</span>
                    </a>
                @else
                    <a href="{{route('vh.backend')}}#/setup" target="_blank"
                       class="p-button p-component p-button-sm no-underline" >
                        <span class="p-button-label">Setup</span>
                    </a>
                @endif



                <a href="https://docs.vaah.dev/vaahcms" target="_blank"
                   class="p-button p-component p-button-sm no-underline mx-3" >
                    <span class="p-button-label">Documentation</span>
                </a>

                <a href="https://github.com/webreinvent/vaahcms" target="_blank"
                   class="p-button p-component p-button-sm no-underline" >
                    <span class="p-button-label">Github</span>
                </a>

            </p>

        </div>
    </div>
@endsection

