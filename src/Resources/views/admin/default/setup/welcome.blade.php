@extends("vaahcms::admin.default.layouts.master")


@section('content')

    <div class="content ">

        <div class="container ht-100p">
            <div class="ht-100p d-flex flex-column align-items-center justify-content-center">

                <div class="navbar-brand">
                    <a href="{{url("/")}}" class="df-logo tx-40">Vaah<span>CMS</span>
                        <small class="tx-10 mg-l-5 mg-t-15" style="letter-spacing:1px;">v{{config('vaahcms.version')}}</small>
                    </a>
                </div>

                <ul class="steps">
                    <li class="step-item">
                        <a href="" class="step-link">
                            <span class="step-number">1</span>
                            <span class="step-title">Database</span>
                        </a>
                    </li>
                    <li class="step-item">
                        <a href="" class="step-link">
                            <span class="step-number">2</span>
                            <span class="step-title">Run Migrations</span>
                        </a>
                    </li>
                    <li class="step-item">
                        <a href="" class="step-link">
                            <span class="step-number">3</span>
                            <span class="step-title">Setup Admin Account</span>
                        </a>
                    </li>
                </ul>

                <h4 class="tx-20 tx-sm-24">Verify your email address</h4>
                <p class="tx-color-03 mg-b-40">Please check your email and click the verify button or link to verify your account.</p>
                <div class="tx-13 tx-lg-14 mg-b-40">
                    <a href="" class="btn btn-brand-02 d-inline-flex align-items-center">Resend Verification</a>
                    <a href="" class="btn btn-white d-inline-flex align-items-center mg-l-5">Contact Support</a>
                </div>
                <span class="tx-12 tx-color-03">Mailbox with envelope vector is created by <a href="https://www.freepik.com/free-photos-vectors/background">freepik (freepik.com)</a></span>
            </div>
        </div>

    </div>

@endsection