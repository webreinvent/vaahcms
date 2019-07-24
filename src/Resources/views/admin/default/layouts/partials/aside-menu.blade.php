<li class="nav-label">Manage</li>

<li class="nav-item with-sub">
    <a href="{{route('vh.admin.vaah')}}" class="nav-link">
        <i data-feather="users"></i> <span>Users & Access</span>
    </a>

    <ul>
        <li><a href="{{route('vh.admin.vaah')}}#/registrations">Registration</a></li>
        <li><a href="{{route('vh.admin.vaah')}}#/users">Users</a></li>
        <li><a href="{{route('vh.admin.vaah')}}#/roles">Roles</a></li>
        <li><a href="{{route('vh.admin.vaah')}}#/permissions">Permissions</a></li>
    </ul>

</li>


<li class="nav-item with-sub">
    <a href="{{route('vh.admin.vaah')}}#/modules" class="nav-link">
        <i data-feather="package"></i> <span>Extend</span>
    </a>

    <ul>
        <li><a href="{{route('vh.admin.vaah')}}#/modules">Modules</a></li>
        <li><a href="{{route('vh.admin.vaah')}}#/themes">Themes</a></li>
    </ul>

</li>



@include("vaahcms::admin.default.extend.aside-menu")