<!DOCTYPE html>
<html lang="en">

    @include("vaahcms::frontend.partials.head")

	<body>

    @include("vaahcms::frontend.partials.alerts")
    @include("vaahcms::frontend.partials.flash")

    @yield('content')


    @include("vaahcms::frontend.partials.scripts")

	</body>
</html>