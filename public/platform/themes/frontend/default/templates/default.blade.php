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
	{{ Theme::asset('css/style.less') }}
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
	<div id="base">
		<div id="page">
			<div class="container">
				<div class="row-fluid">
					<header class="cover span12">
						<div class="about">
							<img class="brand" src="{{ Theme::asset('img/brand.png') }}" title="Platform by Cartalyst LLC">
							<h1>@get.settings.general.title</h1>

							<h2>Platform is an application base, a bootstrap if you will, on Laravel. The fundamentals <span>+</span> a few essentials included. It's well documented, feature awesome, and open source.</h2>

							<p class="love">If you <span class="ico-heart"></span> it, buy it.</p>
							<p class="perks">and recieve 6 months <a href="https://getplatform.com/buy/platform">developer status</a> when you purchase platform.</p>
							<a class="btn btn-large btn-primary buy" href="https://getplatform.com/buy/checkout/platform">Purchase</a>
						</div>
					</div>
				</div
			</div>
			<div class="container-fluid">
				<div class="row-fluid">
					<div class="content span12">
						@yield('content')
					</div>
				</div>
			</div>
		</div>
		<div id="footer">
			<div class="row-fluid">
				<div class="span12">
					<div class="brand">
						<a href="{{ url(ADMIN) }}">
							<img src="{{ Theme::asset('img/brand-footer.png') }}" title="Cartalyst">
						</a>
					</div>
					<div class="legal">
						<p class="copyright">Created, developed, and designed by <a href="http://twitter.com/#!/Cartalyst">@Cartalyst</a></p>
						<p class="licence">The BSD 3-Clause License - Copyright (c) 2011-2012, Cartalyst LLC</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	@yield('body_scripts')

</body>
</html>
