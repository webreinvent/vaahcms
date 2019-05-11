<!DOCTYPE html>
<html lang="en">

    @include("vaahcms::frontend.partials.head")

	<body>

	<?php

	$test = vh_get_plugin_extended_views('menu1');


	echo "<pre>";
	print_r($test);
	echo "</pre>";
	die("<hr/>line number=123");

	//findPluginExtendedViews('menu');

	?>

    @include("vaahcms::frontend.partials.alerts")
    @include("vaahcms::frontend.partials.flash")

    @yield('content')


    @include("vaahcms::frontend.partials.scripts")

	</body>
</html>