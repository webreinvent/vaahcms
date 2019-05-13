<!DOCTYPE html>
<html lang="en">

    @include("vaahcms::admin.themes.default.partials.head")

	<body>

    @include("vaahcms::admin.themes.default.partials.alerts")
    @include("vaahcms::admin.themes.default.partials.flash")

	@include("vaahcms::admin.themes.default.extend.menu")

    @yield('content')


    @include("vaahcms::admin.themes.default.partials.scripts")

	</body>
</html>