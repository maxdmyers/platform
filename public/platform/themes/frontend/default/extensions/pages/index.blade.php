@layout('templates.default')

@section('title')
	Platform
@endsection

@section('links')

@endsection

@section('body_scripts')

@endsection

@section('content')
<section id="welcome">
	<div class="brand">
		<a href="{{ url(ADMIN) }}">
			<img src="{{ Theme::asset('img/brand.png') }}" title="Cartalyst">
		</a>
	</div>
	<div class="about">
		<p class="lead">The Cartalyst Platform is an application base, think of it as a bootstrap for Laravel. It includes all the fundamentals and essentials that are normally required of a web based application. It is well documented, and feature rich.</p>
	</div>
</section>
@endsection
