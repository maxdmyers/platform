<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
<head>

	<!-- Basic Page Needs -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<meta name="description" content="an ecommerce engine">
	<meta name="author" content="Cartalyst LLC">
	<meta name="base_url" content="{{ url() }}">
	<meta name="admin_url" content="{{ url(ADMIN) }}">

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!--[if !IE 7]>
	<style type="text/css">
		#cover {display:table;height:100%}
	</style>
	<![endif]-->

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Links -->
	{{ Theme::asset('css/style.less', 'manuals::css/manuals.less') }}
	@widget('platform.themes::options.css')

	@yield('links')

	@yield('head_scripts')

	<title>
		@yield('title')
	</title>

	<link rel="shortcut icon" href="{{ Theme::asset('img/favicon.png') }}">
	<link rel="apple-touch-icon-precomposed" href="{{ Theme::asset('img/apple-touch-icon-precomposed.png') }}">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ Theme::asset('img/apple-touch-icon-72x72-precomposed.png') }}">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ Theme::asset('img/apple-touch-icon-114x114-precomposed.png') }}">
</head>
<body>

	<div id="cover">
		<div class="curl"></div>
		<div id="main">
			<div class="container-fluid">
				<div class="row-fluid">
					<div class="span12">
						@yield('cover')
					</div>
				</div>
			</div>
		</div>

	</div>

	<div id="footer">
		<p class="copyright">The BSD 3-Clause License - Copyright (c) 2011-2012, Cartalyst LLC</p>
	</div>

	@yield('body_scripts')

</body>
</html>
