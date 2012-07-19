@layout('templates.default')

@section('title')
	{{ Lang::line('users::users.update.title') }}
@endsection

@section('body_scripts')
	{{ Theme::asset('js/bootstrap/bootstrap-tab.js') }}
@endsection

@section('content')
<section id="users-edit">

	<header class="head row">
		<div class="span4">
			<h1>{{ Lang::line('users::users.update.title') }}</h1>
			<p>{{ Lang::line('users::users.update.description') }}</p>
		</div>
	</header>

	<hr>

	<div class="tabbable">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#general" data-toggle="tab">{{ Lang::line('users::users.tabs.general') }}</a></li>
			<li><a href="#permissions" data-toggle="tab">{{ Lang::line('users::users.tabs.permissions') }}</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="general">
				@widget('platform.users::form.edit', $id)
			</div>
			<div class="tab-pane" id="permissions">
				@widget('platform.users::form.permissions', $id)
			</div>
		</div>
	</div>
</section>
@endsection
