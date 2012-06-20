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

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
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

	<!-- Favicons -->
	<link rel="shortcut icon" href="{{ URL::to_asset('platform/manuals/img/favicon.png') }}">
	<link rel="apple-touch-icon-precomposed" href="{{ URL::to_asset('platform/manuals/img/apple-touch-icon-precomposed.png') }}">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ URL::to_asset('platform/manuals/img/apple-touch-icon-72x72-precomposed.png') }}">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ URL::to_asset('platform/manuals/img/apple-touch-icon-114x114-precomposed.png') }}">
</head>
<body>

	<div id="manuals">
		<div class="curl"></div>
		<div class="brand">
			<a href="{{ URL::to('manuals') }}">
				<img src="{{ Theme::asset('manuals::img/brand-icon.png') }}" alt="Platform by Cartalyst">
			</a>
		</div>
		<div id="main">
			<div class="header">
				<div class="row-fluid">

					@yield('header')

				</div>
			</div>

			<div class="page container-fluid">
				<div class="row-fluid">
					<div class="span12">

						@yield('content')

					</div>
				</div>
			</div>
		</div>

	</div>

	<div id="footer">
		<p class="copyright">copyright @ 2011 - 2012, Cartalyst LLC</p>
	</div>

	{{ Theme::asset('js/jquery-1.7.2.min.js', 'js/bootstrap/bootstrap-modal.js', 'js/prettify/prettify.js', 'manuals::js/markdown-extra.js') }}
	@yield('body_scripts')
	{{ Theme::asset('manuals::js/manuals.js') }}

</body>
</html>
