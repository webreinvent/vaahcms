@extends("vaahcms::frontend.layouts.default")


@extends("vaahcms::frontend.layouts.simple")

@section('content')
    <div class="primevue">
        <div class="grid mt-5">
        <div class="col-6 col-offset-3 text-center ">

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
                   class="p-button p-component p-button-sm no-underline" >
                    <span class="p-button-label">Documentation</span>
                </a>

                <a href="https://github.com/webreinvent/vaahcms" target="_blank"
                   class="p-button p-component p-button-sm no-underline" >
                    <span class="p-button-label">Github</span>
                </a>

            </p>

        </div>
    </div>
    </div>
@endsection



<!--sections-->
<section class="section">
    <div class="container has-text-centered ">

        <!--columns-->
        <div class="columns is-centered">
            <div class="column is-6">

                <article class="message is-danger">
                    <div class="message-body">
                        Activated theme does not have any welcome page.
                        Please read theme documentation.
                    </div>
                </article>

            </div>
        </div>
        <!--/columns-->

    </div>
</section>
<!--sections-->

