@layout('templates.template')

@section('title')
	{{ Lang::line('themes::themes.general.title') }}
@endsection

@section('links')
	{{ Theme::asset('themes::css/themes.less') }}
@endsection

@section('body_scripts')
	{{ Theme::asset('themes::js/themes.js') }}
@endsection

@section('content')

<section id="themes">

		<header class="row">
			<div class="span4">
				<h1>{{ Lang::line('themes::themes.general.title') }}</h1>
				<p>{{ Lang::line('themes::themes.general.description') }}</p>
			</div>
			<nav class="span8">
				<div class="pull-right">
					@widget('platform.menus::menus.pills', 'themes')
				</div>
			</nav>
		</header>

		<hr>

		<div class="selections row">
			@if($active)
				<div class="active span3">
					<div class="thumbnail">
						<img src="http://placehold.it/260x180" alt="">
						<div class="caption">
							<h5>{{ $active['name'] }}</h5>
							<p class="version">{{ Lang::line('themes::themes.general.version') }} {{ $active['version'] }}</p>
							<p class="author">{{ Lang::line('themes::themes.general.author') }}  {{ $active['author'] }}</p>
							<p>{{ $active['description'] }}</p>
							<p><a href="edit/backend/{{ $active['dir'] }}" class="btn btn-primary" data-theme="{{ $active['dir'] }}" data-type="backend">Edit</a></p>
						</div>
					</div>
				</div>
			@else
				<div class="active span3">
					<div class="thumbnail">
						<div class="caption">
							<h5>Select a Theme and activate</h5>
						</div>
					</div>
				</div>
			@endif

			@foreach ($inactive as $theme)
			<div class="span3">
				<div class="thumbnail">
					<img src="http://placehold.it/260x180" alt="">
					<div class="caption">
						<h5>{{ $theme['name'] }}</h5>
						<p class="version">{{ Lang::line('themes::themes.general.version') }} {{ $theme['version'] }}</p>
						<p class="author">{{ Lang::line('themes::themes.general.author') }}  {{ $theme['author'] }}</p>
						<p>{{ $theme['description'] }}</p>
						<p><a href="activate/backend/{{ $theme['dir'] }}" class="btn activate" data-theme="{{ $theme['dir'] }}" data-type="backend">Activate</a></p>

					</div>
				</div>
			</div>
			@endforeach
		</div>

@endsection
