<!DOCTYPE html>
<html lang="en">
	<head>

	<title>@if(isset($data->title)){{$data->title}}@else{{config('vaahcms.app_name')}} v{{config('vaahcms.version')}}@endif</title>
	@include("vaahcms::admin.default.layouts.partials.head")
	@include('vaahcms::admin.default.layouts.partials.styles')

	@yield('vaahcms_extend_admin_css')

	</head>
	<body class="@if(isset($data->body_class)){{$data->body_class}}@endif">

    @include("vaahcms::admin.default.layouts.partials.alerts")
    @include("vaahcms::admin.default.layouts.partials.flash")

	@include("vaahcms::admin.default.extend.menu")

    @yield('content')

    @include("vaahcms::admin.default.layouts.partials.scripts")
@yield('vaahcms_extend_admin_js')

	</body>
</html>