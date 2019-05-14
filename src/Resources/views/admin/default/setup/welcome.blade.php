@extends("vaahcms::admin.default.layouts.master")


@section('content')

    <div class="content ">

        <div class="container ht-100p">

            <!--header-->
            <div class="d-flex flex-column align-items-center justify-content-center">

                <div class="navbar-brand">
                    <a href="{{url("/")}}" class="df-logo tx-40">Vaah<span>CMS</span>
                        <small class="tx-10 mg-l-5 mg-t-15" style="letter-spacing:1px;">v{{config('vaahcms.version')}}</small>
                    </a>
                </div>

                <ul class="steps mg-t-50 mg-b-50">
                    <li class="step-item active">
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


            </div>
            <!--/header-->

            <!--form-->
            <div class="row">

                <div class="col-6 offset-3">


                    <form>
                        <div class="form-group row">
                            <label for="dbhost" class="col-sm-3 col-form-label">DB Host</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="dbhost" placeholder="Database Host Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="dbport" class="col-sm-3 col-form-label">DB Port</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="dbport" placeholder="Database Port">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="dbname" class="col-sm-3 col-form-label">DB Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="dbname" placeholder="Database Name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dbusername" class="col-sm-3 col-form-label">DB Username</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="dbusername" placeholder="Database Username">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dbpassword" class="col-sm-3 col-form-label">DB Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="dbpassword" placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group row mg-b-0">

                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>

                        </div>
                    </form>

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

@endsection