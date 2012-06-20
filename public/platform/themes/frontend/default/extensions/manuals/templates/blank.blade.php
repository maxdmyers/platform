<!DOCTYPE HTML>
<!--[if lt IE 9]><html class="ie"><![endif]-->
<!--[if gte IE 9]><!--><html><!--<![endif]-->

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<meta name="description" content="an ecommerce engine">
	<meta name="author" content="Cartalyst LLC">
	<meta name="base_url" content="{{ URL::base() }}">
	<meta name="admin_url" content="{{ URL::to('admin') }}">

	<title>
	@section('title')
	@yield_section
	</title>

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Links -->
	@section('links')
	@yield_section

	<!-- Scripts -->
	@section('head_scripts')
	@yield_section

	<meta name="description" content=""/>
</head>

<body>
	<div id="base">
		@yield('content')
	</div>

	@yield('body_scripts')
</body>
</html>
