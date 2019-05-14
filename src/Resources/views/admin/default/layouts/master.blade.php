<!DOCTYPE html>
<html lang="en">
	<head>

	<title>Title</title>
	@include("vaahcms::admin.default.layouts.partials.head")
	@include('vaahcms::admin.default.layouts.partials.styles')
	</head>
	<body>

    @include("vaahcms::admin.default.layouts.partials.alerts")
    @include("vaahcms::admin.default.layouts.partials.flash")

	@include("vaahcms::admin.default.extend.menu")

    @yield('content')


    @include("vaahcms::admin.default.layouts.partials.scripts")

	</body>
</html>