@layout('templates.default')

@section('title')
	{{ Lang::line('settings::settings.title') }}
@endsection

@section('links')

@endsection

@section('body_scripts')
	{{ Theme::asset('js/bootstrap/bootstrap-tab.js') }}
@endsection

@section('content')
<section id="settings">

	<header class="head row">
		<div class="span6">
			<h1>{{ Lang::line('settings::settings.title') }}</h1>
			<p>{{ Lang::line('settings::settings.description') }}</p>
		</div>
	</header>

	<hr>

	<div class="tabbable">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#general" data-toggle="tab">General</a></li>
			<li><a href="#extra" data-toggle="tab">Extra</a></li>
		</ul>
		<div class="tab-content">
		    <div class="tab-pane active" id="general">
		    	@widget('platform.settings::settings.general')
		    </div>
		    <div class="tab-pane" id="extra">
		    	Add extra settings here
		    </div>
	  	</div>
	</div>

</section>

@endsection
