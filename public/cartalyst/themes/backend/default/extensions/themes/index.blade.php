@layout('templates/template')

@section('title')
	{{ Lang::line('themes::themes.title') }}
@endsection

@section('links')

@endsection

@section('body_scripts')

@endsection

@section('content')
	<div>
		<a class="btn" href="{{ url(ADMIN.'/themes') }}">Front End</a> /
		<a class="btn" href="{{ url(ADMIN.'/themes/backend') }}">Back End</a>
	</div>
@if($exists)
	<section>
		<header><strong>Active Theme</strong></header>
		<div>
			<strong>Name: </strong>{{ $active['name'] }} v{{ $active['version'] }}
			<strong>by</strong> {{ $active['author'] }}
		</div>
		<div><strong>Description: </strong>{{ $active['description'] }}</div>
	</section>

	<br />
	@if (count($active['options']))
		<section>
			<header><strong>Theme Options</strong></header>
			{{ Form::open() }}
				<input type="hidden" name="theme" value="{{ $active['dir'] }}" />
				@if (isset($active['id']))
				<input type="hidden" name="id" value="{{ $active['id'] }}" />
				@endif
				<div>
					<div>
						<label>Options:</label>
						<!-- form_select('status', active.status, {"1":"enabled", "0":"disabled"}) -->
					</div>
					@foreach ($active['options'] as $id => $option)
						<div>
							<strong>{{ $option['text'] }} </strong><br />
							@foreach ($option['styles'] as $style => $value)
								<div>
									<label>{{ $style }}</label>
									<input type="text" name="options[{{$id}}][styles][{{$style}}]" value="{{ $value }}" />
								</div>
							@endforeach
						</div>
					@endforeach
				</div>
				<input type="submit" name="form_options" value="Update" />
			{{ Form::close() }}
		</section>
		<br />

	@endif
@else
	<section>
		<header><strong>Theme: {{ $active['name'] }} no longer exists.</strong></header>
	</section>
@endif
	<section>
		<header><strong>Available Themes</strong></header>
		{{ Form::open() }}
			<ul>
			@foreach ($themes as $theme)
				<li>
					<input type="radio" name="theme" value="{{ $theme['dir'] }}" {{ ($theme['name'] == $active['name']) ? 'checked=checked' : '' }} />
					<div>
						<strong>Name: </strong>{{ $theme['name'] }}  v{{ $theme['version'] }}
						<strong>by</strong> {{ $theme['author'] }}
					</div>
					<div><strong>Description: </strong>{{ $theme['description'] }}</div>
				</li>
			@endforeach
			</ul>
			<input type="submit" name="form_themes" value="Activate" />
		{{ Form::close() }}
	</section>

@endsection
