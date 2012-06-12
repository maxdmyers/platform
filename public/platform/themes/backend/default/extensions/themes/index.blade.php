@layout('templates.template')

@section('title')
	{{ Lang::line('themes::themes.general.title') }}
@endsection

@section('links')

@endsection

@section('body_scripts')
	{{ Theme::asset('themes::js/themes.js') }}
@endsection

@section('content')

<section id="themes">

		<header class="container-fluid">
			<div class="row-fluid">
				<div class="span4">
					<h1>{{ Lang::line('themes::themes.general.title') }}</h1>
					<p>{{ Lang::line('themes::themes.general.description') }}</p>
				</div>
			</div>
		</header>

		<div>
			<!--<ul class="nav nav-tabs">
				<li class="active"><a href="{{ url(ADMIN.'/themes') }}">Front End</a></li>
				<li><a href="{{ url(ADMIN.'/themes/backend') }}">Back End</a></li>
			</ul>-->

			@widget('platform.menus::menus.tabs', 'themes')
		</div>


@if($exists)
	<section>
		<header><strong>Active Theme</strong></header>
		<div>
			<strong>Name: </strong>{{ $active['name'] }} v{{ $active['version'] }}
			<strong>by</strong> {{ $active['author'] }}
		</div>
		<div><strong>Description: </strong>{{ $active['description'] }}</div>
		<div><p><a href="edit/backend/{{ $active['dir'] }}" class="btn btn-primary" data-theme="{{ $active['dir'] }}" data-type="backend">Edit</a></p>
	</section>

	<br>
	<!--@if (count($active['options']))
		<section>
			<header><strong>Theme Options</strong></header>
			{{ Form::open() }}
				<input type="hidden" name="theme" value="{{ $active['dir'] }}">
				@if (isset($active['id']))
				<input type="hidden" name="id" value="{{ $active['id'] }}">
				@endif
				<div>
					<div>
						<label>Options:</label>

					</div>
					@foreach ($active['options'] as $id => $option)
						<div>
							<strong>{{ $option['text'] }} </strong><br>
							@foreach ($option['styles'] as $style => $value)
								<div>
									<label>{{ $style }}</label>
									<input type="text" name="options[{{$id}}][styles][{{$style}}]" value="{{ $value }}">
								</div>
							@endforeach
						</div>
					@endforeach
				</div>
				<input type="submit" name="form_options" value="Update">
			{{ Form::close() }}
		</section>
		<br>

	@endif-->
@else
	<section>
		<header><strong>Theme: {{ $active['name'] }} no longer exists.</strong></header>
	</section>
@endif
	<section id="test">
		<header><strong>Available Themes</strong></header>

			@foreach ($themes as $theme)
			<div class="span3">
				<div class="thumbnail">
					<img src="http://placehold.it/260x180" alt="">
					<div class="caption">
						<h5>{{ $theme['name'] }}</h5>
						<p class="version">{{ Lang::line('themes::themes.general.version') }} {{ $theme['version'] }}</p>
						<p class="author">{{ Lang::line('themes::themes.general.author') }}  {{ $theme['author'] }}</p>
						<p>{{ $theme['description'] }}</p>
						<p><a href="activate/backend/{{ $theme['dir'] }}" class="btn btn-primary activate" data-theme="{{ $theme['dir'] }}" data-type="backend">Activate</a> <a href="#" class="btn">Deactivate</a></p>

					</div>
				</div>
			</div>
			@endforeach

	</section>

@endsection
