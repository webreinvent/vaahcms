<!DOCTYPE html>
<html lang="en">

    @include("vaahcms::frontend.partials.head")

    <body class="@if(isset($data->body_class)){{$data->body_class}}@endif has-background-white-bis">


    <?php

	//vh_get_modules_extended_views('menu');


	?>

    @include("vaahcms::frontend.partials.errors")
    @include("vaahcms::frontend.partials.flash")

    @yield('content')


    @include("vaahcms::frontend.partials.scripts")

	</body>
</html>
