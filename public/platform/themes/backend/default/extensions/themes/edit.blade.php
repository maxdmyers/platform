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



	<section>
		<header><strong>Active Theme</strong></header>
		<div>
			<strong>Name: </strong>{{ $theme['name'] }} v{{ $theme['version'] }}
			<strong>by</strong> {{ $theme['author'] }}
		</div>
		<div><strong>Description: </strong>{{ $theme['description'] }}</div>
		<div><p><a href="edit/backend/{{ $theme['dir'] }}" class="btn btn-primary" data-theme="{{ $theme['dir'] }}" data-type="backend">Edit</a></p>
	</section>


	@if (count($theme['options']))
		<section>
			<header><strong>Theme Options</strong></header>
			{{ Form::open() }}
				<input type="hidden" name="theme" value="{{ $theme['dir'] }}">
				@if (isset($theme['id']))
				<input type="hidden" name="id" value="{{ $theme['id'] }}">
				@endif
				<div>
					<div>
						<label>Options:</label>

					</div>
					@foreach ($theme['options'] as $id => $option)
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

	@endif


@endsection
