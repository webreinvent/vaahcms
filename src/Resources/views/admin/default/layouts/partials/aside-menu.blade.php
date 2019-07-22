<li class="nav-label">Manage</li>
<li class="nav-item">
    <a href="{{route('vh.admin.vaah')}}" class="nav-link">
        <i data-feather="package"></i> <span>Vaah</span>
    </a>
</li>


{{--<li class="nav-item with-sub">
    <a href="#" class="nav-link">
        <i data-feather="settings"></i> <span>Settings</span>
    </a>

    <ul>
        <li><a href="{{route("vh.admin.vaahcms.settings")}}">General</a></li>
        @include("vaahcms::admin.default.extend.settings-menu")
    </ul>

</li>--}}



@include("vaahcms::admin.default.extend.aside-menu")