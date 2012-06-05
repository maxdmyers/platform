@layout('templates.template')

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

	@widget('settings::settings.general')

</section>

@endsection
