<!DOCTYPE HTML>
<!--[if lt IE 9]><html class="ie"><![endif]-->
<!--[if gte IE 9]><!--><html><!--<![endif]-->

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<meta name="description" content="a base application on Laravel">
	<meta name="author" content="Cartalyst LLC">
	<meta name="base_url" content="{{ URL::base() }}">

	<title>
	@yield('title')
	</title>

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Links -->
	{{ Theme::asset('css/style.css') }}
	@widget('platform.themes::options.css')

	@yield('links')

	<!-- Scripts -->
	@yield('head_scripts')
</head>

<body>
	<div id="base">
		<div id="page">
			<nav>@widget('platform.menus::menus.nav', 'front', 1, 'nav nav-tabs')</nav>
			@yield('content')
		</div>
	</div>

	@yield('body_scripts')
</body>
</html>
