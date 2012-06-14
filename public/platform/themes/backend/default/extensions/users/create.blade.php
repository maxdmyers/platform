@layout('templates.template')

@section('title')
	{{ Lang::line('users::users.create.title') }}
@endsection

@section('content')

<section id="users">

	<header class="head row">
		<div class="span4">
			<h1>{{ Lang::line('users::users.create.title') }}</h1>
			<p>{{ Lang::line('users::users.create.description') }}</p>
		</div>
		<nav class="tertiary-navigation span8">
			@widget('platform.menus::menus.nav', 2, 1, 'nav nav-pills pull-right', ADMIN)
		</nav>
	</header>

	<hr>
	<div class="row">
		<div class="span12">
			@widget('platform.users::form.create')
		</div>
	</div>

</section>

@endsection
