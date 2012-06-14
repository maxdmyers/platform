@layout('templates.template')

@section('title')
	{{ Lang::line('users::users.title_edit') }}
@endsection

@section('body_scripts')
	{{ Theme::asset('js/bootstrap/bootstrap-tab.js') }}
@endsection

@section('content')
<section id="users-edit">

	<header class="head row">
		<div class="span4">
			<h1>{{ Lang::line('users::users.title_edit') }}</h1>
			<p>{{ Lang::line('users::users.description') }}</p>
		</div>
		<nav class="tertiary-navigation span8">
			@widget('platform.menus::menus.nav', 2, 1, 'nav nav-pills pull-right', ADMIN)
		</nav>
	</header>

	<hr>
	<div class="tabbable">
		<ul class="nav nav-pills">
			<li class="active"><a href="#general" data-toggle="tab">General</a></li>
			<li><a href="#permissions" data-toggle="tab">Permissions</a></li>
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
