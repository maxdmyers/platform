@layout('templates/template')

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

	<header>
		<h1 class="large">{{ Lang::line('settings::settings.title') }}</h1>
		<p>{{ Lang::line('settings::settings.description') }}</p>
	</header>

	<div class="tabbable">

		<ul class="nav nav-tabs">
			<li class="active"><a href="#1" data-toggle="tab">{{ Lang::line('settings::settings.general_title') }}</a></li>
			<li><a href="#2" data-toggle="tab">{{ Lang::line('settings::settings.localization_title') }}</a></li>
		</ul>

		{{ Form::open() }}
			<div class="tab-content">
				<div class="tab-pane active" id="1">
					@widget('settings::form.general')
				</div>
				<div class="tab-pane" id="2">
					@widget('settings::form.localization')
				</div>
			</div>

			<input type="submit" value="Update" />
		{{ Form::close() }}
	</div>

</section>

@endsection
