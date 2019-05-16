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
				<li class="nav-label">Users</li>
				<li class="nav-item"><a href="dashboard-one.html" class="nav-link"><i data-feather="shopping-bag"></i> <span>Sales Monitoring</span></a></li>
				<li class="nav-item"><a href="dashboard-two.html" class="nav-link"><i data-feather="globe"></i> <span>Website Analytics</span></a></li>
				<li class="nav-item"><a href="dashboard-three.html" class="nav-link"><i data-feather="pie-chart"></i> <span>Cryptocurrency</span></a></li>
				<li class="nav-item"><a href="dashboard-four.html" class="nav-link"><i data-feather="life-buoy"></i> <span>Helpdesk Management</span></a></li>
				<li class="nav-label mg-t-25">Web Apps</li>
				<li class="nav-item"><a href="app-calendar.html" class="nav-link"><i data-feather="calendar"></i> <span>Calendar</span></a></li>
				<li class="nav-item"><a href="app-chat.html" class="nav-link"><i data-feather="message-square"></i> <span>Chat</span></a></li>
				<li class="nav-item"><a href="app-contacts.html" class="nav-link"><i data-feather="users"></i> <span>Contacts</span></a></li>
				<li class="nav-item active"><a href="app-file-manager.html" class="nav-link"><i data-feather="file-text"></i> <span>File Manager</span></a></li>
				<li class="nav-item"><a href="app-mail.html" class="nav-link"><i data-feather="mail"></i> <span>Mail</span></a></li>

				<li class="nav-label mg-t-25">Pages</li>
				<li class="nav-item with-sub">
					<a href="#" class="nav-link"><i data-feather="user"></i> <span>User Pages</span></a>
					<ul>
						<li><a href="page-profile-view.html">View Profile</a></li>
						<li><a href="page-connections.html">Connections</a></li>
						<li><a href="page-groups.html">Groups</a></li>
						<li><a href="page-events.html">Events</a></li>
					</ul>
				</li>
				<li class="nav-item with-sub">
					<a href="#" class="nav-link"><i data-feather="file"></i> <span>Other Pages</span></a>
					<ul>
						<li><a href="page-timeline.html">Timeline</a></li>
					</ul>
				</li>
				<li class="nav-label mg-t-25">User Interface</li>
				<li class="nav-item"><a href="http://themepixels.me/dashforge/components" class="nav-link"><i data-feather="layers"></i> <span>Components</span></a></li>
				<li class="nav-item"><a href="http://themepixels.me/dashforge/collections" class="nav-link"><i data-feather="box"></i> <span>Collections</span></a></li>
			</ul>
		</div>



	</aside>
	<!--/aside-->

	<!--content-->

	<div class="content ht-100v pd-0">

		<header class="navbar navbar-header">
			<button class="navbar-toggler mg-l-20" type="button" data-toggle="collapse" data-target="#class" >
				<span class="navbar-toggler-icon"></span>
			</button>

			<a href="" id="mainMenuOpen" class="burger-menu"><i data-feather="menu"></i></a>

			<div id="navbarMenu" class="navbar-menu-wrapper">
				<div class="navbar-menu-header">
					<a href="../../index.html" class="df-logo">dash<span>forge</span></a>
					<a id="mainMenuClose" href=""><i data-feather="x"></i></a>
				</div><!-- navbar-menu-header -->
				<ul class="nav navbar-menu">
					<li class="nav-label pd-l-20 pd-lg-l-25 d-lg-none">Main Navigation</li>
					<li class="nav-item with-sub active">
						<a href="" class="nav-link"><i data-feather="pie-chart"></i> Dashboard</a>
						<ul class="navbar-menu-sub">
							<li class="nav-sub-item"><a href="dashboard-one.html" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Sales Monitoring</a></li>
							<li class="nav-sub-item"><a href="dashboard-two.html" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Website Analytics</a></li>
							<li class="nav-sub-item"><a href="dashboard-three.html" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Cryptocurrency</a></li>
							<li class="nav-sub-item"><a href="dashboard-four.html" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Helpdesk Management</a></li>
						</ul>
					</li>
					<li class="nav-item with-sub">
						<a href="" class="nav-link"><i data-feather="package"></i> Apps</a>
						<ul class="navbar-menu-sub">
							<li class="nav-sub-item"><a href="app-calendar.html" class="nav-sub-link"><i data-feather="calendar"></i>Calendar</a></li>
							<li class="nav-sub-item"><a href="app-chat.html" class="nav-sub-link"><i data-feather="message-square"></i>Chat</a></li>
							<li class="nav-sub-item"><a href="app-contacts.html" class="nav-sub-link"><i data-feather="users"></i>Contacts</a></li>
							<li class="nav-sub-item"><a href="app-file-manager.html" class="nav-sub-link"><i data-feather="file-text"></i>File Manager</a></li>
							<li class="nav-sub-item"><a href="app-mail.html" class="nav-sub-link"><i data-feather="mail"></i>Mail</a></li>
						</ul>
					</li>
					<li class="nav-item with-sub">
						<a href="" class="nav-link"><i data-feather="layers"></i> Pages</a>
						<div class="navbar-menu-sub">
							<div class="d-lg-flex">
								<ul>
									<li class="nav-label">Authentication</li>
									<li class="nav-sub-item"><a href="page-signin.html" class="nav-sub-link"><i data-feather="log-in"></i> Sign In</a></li>
									<li class="nav-sub-item"><a href="page-signup.html" class="nav-sub-link"><i data-feather="user-plus"></i> Sign Up</a></li>
									<li class="nav-sub-item"><a href="page-verify.html" class="nav-sub-link"><i data-feather="user-check"></i> Verify Account</a></li>
									<li class="nav-sub-item"><a href="page-forgot.html" class="nav-sub-link"><i data-feather="shield-off"></i> Forgot Password</a></li>
									<li class="nav-label mg-t-20">User Pages</li>
									<li class="nav-sub-item"><a href="page-profile-view.html" class="nav-sub-link"><i data-feather="user"></i> View Profile</a></li>
									<li class="nav-sub-item"><a href="page-connections.html" class="nav-sub-link"><i data-feather="users"></i> Connections</a></li>
									<li class="nav-sub-item"><a href="page-groups.html" class="nav-sub-link"><i data-feather="users"></i> Groups</a></li>
									<li class="nav-sub-item"><a href="page-events.html" class="nav-sub-link"><i data-feather="calendar"></i> Events</a></li>
								</ul>
								<ul>
									<li class="nav-label">Error Pages</li>
									<li class="nav-sub-item"><a href="page-404.html" class="nav-sub-link"><i data-feather="file"></i> 404 Page Not Found</a></li>
									<li class="nav-sub-item"><a href="page-500.html" class="nav-sub-link"><i data-feather="file"></i> 500 Internal Server</a></li>
									<li class="nav-sub-item"><a href="page-503.html" class="nav-sub-link"><i data-feather="file"></i> 503 Service Unavailable</a></li>
									<li class="nav-sub-item"><a href="page-505.html" class="nav-sub-link"><i data-feather="file"></i> 505 Forbidden</a></li>
									<li class="nav-label mg-t-20">Other Pages</li>
									<li class="nav-sub-item"><a href="page-timeline.html" class="nav-sub-link"><i data-feather="file-text"></i> Timeline</a></li>
									<li class="nav-sub-item"><a href="page-pricing.html" class="nav-sub-link"><i data-feather="file-text"></i> Pricing</a></li>
									<li class="nav-sub-item"><a href="page-help-center.html" class="nav-sub-link"><i data-feather="file-text"></i> Help Center</a></li>
									<li class="nav-sub-item"><a href="page-invoice.html" class="nav-sub-link"><i data-feather="file-text"></i> Invoice</a></li>
								</ul>
							</div>
						</div><!-- nav-sub -->
					</li>
					<li class="nav-item"><a href="../../components/" class="nav-link"><i data-feather="box"></i> Components</a></li>
					<li class="nav-item"><a href="../../collections/" class="nav-link"><i data-feather="archive"></i> Collections</a></li>
				</ul>
			</div><!-- navbar-menu-wrapper -->
			<div class="navbar-right">
				<a id="navbarSearch" href="" class="search-link"><i data-feather="search"></i></a>
				<div class="dropdown dropdown-message">
					<a href="" class="dropdown-link new-indicator" data-toggle="dropdown">
						<i data-feather="message-square"></i>
						<span>5</span>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<div class="dropdown-header">New Messages</div>
						<a href="" class="dropdown-item">
							<div class="media">
								<div class="avatar avatar-sm avatar-online"><img src="../../assets/img/img6.jpg" class="rounded-circle" alt=""></div>
								<div class="media-body mg-l-15">
									<strong>Socrates Itumay</strong>
									<p>nam libero tempore cum so...</p>
									<span>Mar 15 12:32pm</span>
								</div><!-- media-body -->
							</div><!-- media -->
						</a>
						<a href="" class="dropdown-item">
							<div class="media">
								<div class="avatar avatar-sm avatar-online"><img src="../../assets/img/img8.jpg" class="rounded-circle" alt=""></div>
								<div class="media-body mg-l-15">
									<strong>Joyce Chua</strong>
									<p>on the other hand we denounce...</p>
									<span>Mar 13 04:16am</span>
								</div><!-- media-body -->
							</div><!-- media -->
						</a>
						<a href="" class="dropdown-item">
							<div class="media">
								<div class="avatar avatar-sm avatar-online"><img src="../../assets/img/img7.jpg" class="rounded-circle" alt=""></div>
								<div class="media-body mg-l-15">
									<strong>Althea Cabardo</strong>
									<p>is there anyone who loves...</p>
									<span>Mar 13 02:56am</span>
								</div><!-- media-body -->
							</div><!-- media -->
						</a>
						<a href="" class="dropdown-item">
							<div class="media">
								<div class="avatar avatar-sm avatar-online"><img src="../../assets/img/img9.jpg" class="rounded-circle" alt=""></div>
								<div class="media-body mg-l-15">
									<strong>Adrian Monino</strong>
									<p>duis aute irure dolor in repre...</p>
									<span>Mar 12 10:40pm</span>
								</div><!-- media-body -->
							</div><!-- media -->
						</a>
						<div class="dropdown-footer"><a href="">View all Messages</a></div>
					</div><!-- dropdown-menu -->
				</div><!-- dropdown -->
				<div class="dropdown dropdown-notification">
					<a href="" class="dropdown-link new-indicator" data-toggle="dropdown">
						<i data-feather="bell"></i>
						<span>2</span>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<div class="dropdown-header">Notifications</div>
						<a href="" class="dropdown-item">
							<div class="media">
								<div class="avatar avatar-sm avatar-online"><img src="../../assets/img/img6.jpg" class="rounded-circle" alt=""></div>
								<div class="media-body mg-l-15">
									<p>Congratulate <strong>Socrates Itumay</strong> for work anniversaries</p>
									<span>Mar 15 12:32pm</span>
								</div><!-- media-body -->
							</div><!-- media -->
						</a>
						<a href="" class="dropdown-item">
							<div class="media">
								<div class="avatar avatar-sm avatar-online"><img src="../../assets/img/img8.jpg" class="rounded-circle" alt=""></div>
								<div class="media-body mg-l-15">
									<p><strong>Joyce Chua</strong> just created a new blog post</p>
									<span>Mar 13 04:16am</span>
								</div><!-- media-body -->
							</div><!-- media -->
						</a>
						<a href="" class="dropdown-item">
							<div class="media">
								<div class="avatar avatar-sm avatar-online"><img src="../../assets/img/img7.jpg" class="rounded-circle" alt=""></div>
								<div class="media-body mg-l-15">
									<p><strong>Althea Cabardo</strong> just created a new blog post</p>
									<span>Mar 13 02:56am</span>
								</div><!-- media-body -->
							</div><!-- media -->
						</a>
						<a href="" class="dropdown-item">
							<div class="media">
								<div class="avatar avatar-sm avatar-online"><img src="../../assets/img/img9.jpg" class="rounded-circle" alt=""></div>
								<div class="media-body mg-l-15">
									<p><strong>Adrian Monino</strong> added new comment on your photo</p>
									<span>Mar 12 10:40pm</span>
								</div><!-- media-body -->
							</div><!-- media -->
						</a>
						<div class="dropdown-footer"><a href="">View all Notifications</a></div>
					</div><!-- dropdown-menu -->
				</div><!-- dropdown -->
				<div class="dropdown dropdown-profile">
					<a href="" class="dropdown-link" data-toggle="dropdown" data-display="static">
						<div class="avatar avatar-sm"><img src="{{vh_get_admin_file('assets/img/img1.png')}}" class="rounded-circle" alt=""></div>
					</a><!-- dropdown-link -->
					<div class="dropdown-menu dropdown-menu-right tx-13">
						<div class="avatar avatar-lg mg-b-15"><img src="{{vh_get_admin_file('assets/img/img1.png')}}" class="rounded-circle" alt=""></div>
						<h6 class="tx-semibold mg-b-5">Katherine Pechon</h6>
						<p class="mg-b-25 tx-12 tx-color-03">Administrator</p>

						<a href="" class="dropdown-item"><i data-feather="edit-3"></i> Edit Profile</a>
						<a href="page-profile-view.html" class="dropdown-item"><i data-feather="user"></i> View Profile</a>
						<div class="dropdown-divider"></div>
						<a href="page-help-center.html" class="dropdown-item"><i data-feather="help-circle"></i> Help Center</a>
						<a href="" class="dropdown-item"><i data-feather="life-buoy"></i> Forum</a>
						<a href="" class="dropdown-item"><i data-feather="settings"></i>Account Settings</a>
						<a href="" class="dropdown-item"><i data-feather="settings"></i>Privacy Settings</a>
						<a href="page-signin.html" class="dropdown-item"><i data-feather="log-out"></i>Sign Out</a>
					</div><!-- dropdown-menu -->
				</div><!-- dropdown -->
			</div><!-- navbar-right -->
			<div class="navbar-search">
				<div class="navbar-search-header">
					<input type="search" class="form-control" placeholder="Type and hit enter to search...">
					<button class="btn"><i data-feather="search"></i></button>
					<a id="navbarSearchClose" href="" class="link-03 mg-l-5 mg-lg-l-10"><i data-feather="x"></i></a>
				</div><!-- navbar-search-header -->
				<div class="navbar-search-body">
					<label class="tx-10 tx-medium tx-uppercase tx-spacing-1 tx-color-03 mg-b-10 d-flex align-items-center">Recent Searches</label>
					<ul class="list-unstyled">
						<li><a href="dashboard-one.html">modern dashboard</a></li>
						<li><a href="app-calendar.html">calendar app</a></li>
						<li><a href="../../collections/modal.html">modal examples</a></li>
						<li><a href="../../components/el-avatar.html">avatar</a></li>
					</ul>

					<hr class="mg-y-30 bd-0">

					<label class="tx-10 tx-medium tx-uppercase tx-spacing-1 tx-color-03 mg-b-10 d-flex align-items-center">Search Suggestions</label>

					<ul class="list-unstyled">
						<li><a href="dashboard-one.html">cryptocurrency</a></li>
						<li><a href="app-calendar.html">button groups</a></li>
						<li><a href="../../collections/modal.html">form elements</a></li>
						<li><a href="../../components/el-avatar.html">contact app</a></li>
					</ul>
				</div><!-- navbar-search-body -->
			</div><!-- navbar-search -->
		</header><!-- navbar -->


		<div class="content-header">
			<div class="content-search">
				<i data-feather="search"></i>
				<input type="search" class="form-control" placeholder="Search files">
			</div>
			<nav class="nav">
				<a href="#" class="nav-link"><i data-feather="help-circle"></i></a>
				<a href="#" class="nav-link"><i data-feather="grid"></i></a>
				<a href="#" class="nav-link"><i data-feather="align-left"></i></a>
			</nav>
		</div><!-- content-header -->

		<div class="content-body pd-0">
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