<div class="dropdown dropdown-profile">
    <a href="" class="dropdown-link" data-toggle="dropdown" data-target="#user-menu" data-display="static">
        <div class="avatar avatar-sm"><img src="{{\Auth::user()->thumbnail}}" class="rounded-circle" alt=""></div>
    </a><!-- dropdown-link -->
    <div class="dropdown-menu dropdown-menu-right tx-13" id="user-menu">
        <div class="avatar avatar-lg mg-b-15">
            <img src="{{\Auth::user()->thumbnail}}" class="rounded-circle" alt="">
        </div>
        <h6 class="tx-semibold mg-b-5">
            {{\Auth::user()->first_name}}
            @if(\Auth::user()->last_name)
                {{\Auth::user()->last_name}}
                @endif

        </h6>
        {{--<p class="mg-b-25 tx-12 tx-color-03">Administrator</p>--}}

        {{--<a href="" class="dropdown-item"><i data-feather="edit-3"></i> Edit Profile</a>
        <a href="page-profile-view.html" class="dropdown-item"><i data-feather="user"></i> View Profile</a>--}}

        <div class="dropdown-divider"></div>
        {{--<a href="" class="dropdown-item"><i data-feather="settings"></i>Account Settings</a>--}}
        <a href="{{route('vh.backend.logout')}}" class="dropdown-item"><i data-feather="log-out"></i>Sign Out</a>
    </div>
</div>
