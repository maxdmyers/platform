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

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Links -->
	{{ Asset::styles() }}

	<title>
	@yield('title')
	</title>

	<!-- Favicons -->
	<link rel="shortcut icon" href="{{ URL::to_asset('platform/installer/img/favicon.png') }}">
	<link rel="apple-touch-icon-precomposed" href="{{ URL::to_asset('platform/installer/img/apple-touch-icon-precomposed.png') }}">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ URL::to_asset('platform/installer/img/apple-touch-icon-72x72-precomposed.png') }}">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ URL::to_asset('platform/installer/img/apple-touch-icon-114x114-precomposed.png') }}">
</head>
<body>
<div id="installer" class="grid">
	<div id="page" class="rows expand">
		<div id="inside" class="grid wrapper">
			<div class="navigation column">
				<div class="brand">
					{{ HTML::image('platform/installer/img/brand.png', 'Platform by Cartalyst'); }}
				</div>
				@yield('navigation')
			</div>

			<div class="content column expand">
				@yield('content')
			</div>
		</div>
	</div>
</div>
</body>

	<!-- Body Scripts -->
	{{ Asset::scripts() }}

</body>
</html>
