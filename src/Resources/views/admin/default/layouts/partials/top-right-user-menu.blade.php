<div class="dropdown dropdown-profile">
    <a href="" class="dropdown-link" data-toggle="dropdown" data-display="static">
        <div class="avatar avatar-sm"><img src="{{vh_get_admin_file('img/img1.png')}}" class="rounded-circle" alt=""></div>
    </a><!-- dropdown-link -->
    <div class="dropdown-menu dropdown-menu-right tx-13">
        <div class="avatar avatar-lg mg-b-15"><img src="{{vh_get_admin_file('img/img1.png')}}" class="rounded-circle" alt=""></div>
        <h6 class="tx-semibold mg-b-5">Katherine Pechon</h6>
        <p class="mg-b-25 tx-12 tx-color-03">Administrator</p>

        <a href="" class="dropdown-item"><i data-feather="edit-3"></i> Edit Profile</a>
        <a href="page-profile-view.html" class="dropdown-item"><i data-feather="user"></i> View Profile</a>


        @include("vaahcms::admin.default.extend.user-menu")

        <div class="dropdown-divider"></div>
        <a href="" class="dropdown-item"><i data-feather="settings"></i>Account Settings</a>
        <a href="page-signin.html" class="dropdown-item"><i data-feather="log-out"></i>Sign Out</a>
    </div>
</div>