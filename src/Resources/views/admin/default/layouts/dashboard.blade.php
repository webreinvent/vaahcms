<!DOCTYPE html>
<html lang="en">
<head>

	<title>@if(isset($data->title)){{$data->title}}@else{{config('vaahcms.app_name')}} v{{config('vaahcms.version')}}@endif</title>
	@include("vaahcms::admin.default.layouts.partials.head")

	@include('vaahcms::admin.default.layouts.partials.styles')

	@yield('vaahcms_extend_admin_css')

</head>
<body class="@if(isset($data->body_class)){{$data->body_class}}@endif">

<div class="container">
	<div class="row">
		<div class="col-12">
			@include("vaahcms::admin.default.layouts.partials.errors")
			@include("vaahcms::admin.default.layouts.partials.flash")
		</div>
	</div>

</div>


<!--aside-->
<aside class="aside aside-fixed aside-filemgr">
	<div class="aside-header">

		@include('vaahcms::admin.default.layouts.partials.aside-logo')

		<a href="#" class="aside-menu-link">
			<i data-feather="menu"></i>
			<i data-feather="x"></i>
		</a>

	</div>

	<div class="aside-body">

		<ul class="nav nav-aside">

			@include("vaahcms::admin.default.layouts.partials.aside-menu")

		</ul>
	</div>



</aside>
<!--/aside-->

<!--content-->

<div class="content ht-100v pd-0">

	<header class="navbar navbar-header">

		<a href="" id="mainMenuOpen" class="burger-menu mg-l-70-f"><i data-feather="menu"></i></a>

		<div id="navbarMenu" class="navbar-menu-wrapper">

			<ul class="nav navbar-menu">
				@include("vaahcms::admin.default.layouts.partials.top-left-menu")
			</ul>

		</div>
		<!-- navbar-menu-wrapper -->
		<div class="navbar-right">
			@include("vaahcms::admin.default.layouts.partials.top-right-menu")
			@include("vaahcms::admin.default.layouts.partials.top-right-user-menu")
		</div>

		@include("vaahcms::admin.default.layouts.partials.top-search-bar")

	</header>


	<div class="content-body">
		@yield('content')
	</div>
</div>

<!--/content-->



@include("vaahcms::admin.default.extend.menu")

@include("vaahcms::admin.default.layouts.partials.scripts")

@yield('vaahcms_extend_admin_js')


<script>
	'use strict'

	$(document).ready(function(){
		if(window.matchMedia('(min-width: 1200px)').matches) {
			$('.aside').addClass('minimize');
		}
	})
</script>

</body>
</html>