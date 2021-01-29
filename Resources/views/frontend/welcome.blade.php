@extends("vaahcms::frontend.layouts.default")

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

