<li class="nav-label">Manage</li>
<li class="nav-item with-sub"><a href="dashboard-one.html" class="nav-link">
        <i data-feather="users"></i> <span>Users & Access</span>
    </a>

    <ul>
        <li><a href="page-profile-view.html">Users</a></li>
        <li><a href="page-profile-view.html">Roles</a></li>
        <li><a href="page-connections.html">Permissions</a></li>
    </ul>

</li>

<li class="nav-item with-sub">
    <a href="dashboard-one.html" class="nav-link">
        <i data-feather="package"></i> <span>Extend</span>
    </a>

    <ul>
        <li><a href="{{url()->route('vh.admin.modules')}}">Modules (3)</a></li>
        <li><a href="page-profile-view.html">Plugins  (4)</a></li>
        <li><a href="page-profile-view.html">Widgets</a></li>
        <li><a href="{{url()->route('vh.admin.themes')}}">Themes</a></li>
    </ul>

</li>

<li class="nav-item with-sub">
    <a href="#" class="nav-link">
        <i data-feather="settings"></i> <span>Settings</span>
    </a>

    <ul>
        <li><a href="{{url()->route("vh.admin.vaahcms.settings")}}">General</a></li>
        @include("vaahcms::admin.default.extend.settings-menu")
    </ul>

</li>



@include("vaahcms::admin.default.extend.aside-menu")