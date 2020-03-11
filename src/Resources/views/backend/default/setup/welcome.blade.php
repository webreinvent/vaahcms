@extends("vaahcms::admin.default.layouts.master")

@section('vaahcms_extend_admin_css')

@endsection


@section('vaahcms_extend_admin_js')
    <script src="{{vh_get_admin_assets("builds/app-setup.js")}}" defer></script>
@endsection

@section('content')

    <div id="vh-app-setup">

        <div class="content ">

            <div class="container ht-100p">

                <!--header-->
                <div class="d-flex flex-column align-items-center justify-content-center">

                    @include('vaahcms::admin.default.layouts.partials.brand')

                    <ul v-if="active_step != 'completed'" class="steps mg-t-50 mg-b-50">
                        <li class="step-item" v-bind:class="{'active': active_step == 'database'}">
                            <a href="javascript:void(0)" class="step-link">
                                <span class="step-number">1</span>
                                <span class="step-title">App & Database Details</span>
                            </a>
                        </li>
                        <li class="step-item" v-bind:class="{'active': active_step == 'run_migrations'}">
                            <a href="javascript:void(0)" class="step-link">
                                <span class="step-number">2</span>
                                <span class="step-title">Run Migrations</span>
                            </a>
                        </li>
                        <li class="step-item" v-bind:class="{'active': active_step == 'cms_setup'}">
                            <a href="javascript:void(0)" class="step-link" >
                                <span class="step-number">3</span>
                                <span class="step-title">CMS Setup</span>
                            </a>
                        </li>
                        <li class="step-item" v-bind:class="{'active': active_step == 'create_admin_account'}">
                            <a href="javascript:void(0)" class="step-link" >
                                <span class="step-number">4</span>
                                <span class="step-title">Create Admin Account</span>
                            </a>
                        </li>
                    </ul>




                </div>
                <!--/header-->

                <!--form-->
                <div class="row">

                    <div class="col-sm-12 col-md-6 offset-md-3" v-if="active_step">

                        <div v-if="active_step == 'completed'">
                            <div class="alert alert-success" v-if="flash_message">
                                <p class="text-center mg-0" v-html="flash_message"></p>
                            </div>
                        </div>

                        <div v-else>

                            @include("vaahcms::admin.default.setup.partials.setup-db-details")
                            @include("vaahcms::admin.default.setup.partials.setup-run-migrations")
                            @include("vaahcms::admin.default.setup.partials.setup-cms-setup")
                            @include("vaahcms::admin.default.setup.partials.setup-create-admin")

                        </div>


                    </div>


                </div>
                <!--/form-->

                <!--footer-->
                <div class="d-flex flex-column align-items-center justify-content-center mg-t-50">
                    <span class="tx-12 tx-color-03">VaahCMS is developed by <a href="https://www.webreinvent.com">WebReinvent</a></span>
                </div>
                <!--/footer-->

            </div>

        </div>


    </div>

@endsection

