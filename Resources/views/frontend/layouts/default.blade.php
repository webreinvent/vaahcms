<!DOCTYPE html>
<html lang="en">

    @include("vaahcms::frontend.partials.head")

    <body class="@if(isset($data->body_class)){{$data->body_class}}@endif">

    @include("vaahcms::frontend.partials.errors")
    @include("vaahcms::frontend.partials.flash")

    @yield('content')

    @include("vaahcms::frontend.partials.scripts")

	</body>
</html>
