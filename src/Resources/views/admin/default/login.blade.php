@extends("vaahcms::admin.default.layouts.master")

@section('vaahcms_extend_admin_js')
    <script src="{{vh_get_admin_assets('assets/css/dashforge.auth.css')}}"></script>
@endsection


@section('vaahcms_extend_admin_js')
    <script src="{{vh_get_admin_assets('assets/js/setup.js')}}"></script>
@endsection

@section('content')


    <div class="content content-fixed content-auth">
        <div class="container">
            <div class="media align-items-stretch justify-content-center ht-100p pos-relative">
                <div class="media-body align-items-center d-none d-lg-flex">
                    <div class="mx-wd-600">
                        <img src="{{vh_get_admin_file("assets/img/img15.png")}}" class="img-fluid" alt="">
                    </div>
                    <div class="pos-absolute b-0 l-0 tx-12 tx-center">

                        @include('vaahcms::admin.default.layouts.partials.credits')

                    </div>
                </div><!-- media-body -->
                <div class="sign-wrapper mg-lg-l-50 mg-xl-l-60">
                    <div class="wd-100p">
                        <h3 class="tx-color-01 mg-b-5">Sign In</h3>
                        <p class="tx-color-03 tx-16 mg-b-40">Welcome back! Please signin to continue.</p>

                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" class="form-control" placeholder="yourname@yourmail.com">
                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-between mg-b-5">
                                <label class="mg-b-0-f">Password</label>
                                <a href="" class="tx-13">Forgot password?</a>
                            </div>
                            <input type="password" class="form-control" placeholder="Enter your password">
                        </div>
                        <button class="btn btn-brand-02 btn-block">Sign In</button>
                        <div class="divider-text">or</div>
                        <button class="btn btn-outline-facebook btn-block">Sign In With Facebook</button>
                        <button class="btn btn-outline-twitter btn-block">Sign In With Twitter</button>
                        <div class="tx-13 mg-t-20 tx-center">Don't have an account? <a href="#">Create an Account</a></div>
                    </div>
                </div><!-- sign-wrapper -->
            </div><!-- media -->
        </div><!-- container -->
    </div><!-- content -->


@endsection