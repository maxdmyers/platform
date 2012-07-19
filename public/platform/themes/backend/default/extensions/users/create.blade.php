@layout('templates.default')

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
	</header>

	<hr>

	<div class="row">
		<div class="span12">
			@widget('platform.users::form.create')
		</div>
	</div>

</section>

@endsection
