<!DOCTYPE html>
<html lang="en">

    @include("vaahcms::frontend.partials.head")

    <body class="@if(isset($data->body_class)){{$data->body_class}}@endif has-background-white-bis">

    @yield('content')

    @include("vaahcms::frontend.partials.scripts")

	</body>
</html>
