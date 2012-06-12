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
				<h1>{{ $theme['name'] }}</h1>
				<p>{{ $theme['description'] }} by {{ $theme['author'] }} v{{ $theme['version'] }}</p>
			</div>
		</header>

		<hr>

		<div class="theme row">

			<div class="span12">

				@if (count($theme['options']))

							<header><strong>Theme Options</strong></header>
							{{ Form::open(null, 'POST', array('id' => 'theme-options', 'class' => 'form-horizontal')) }}
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
								<input type="submit" name="form_options" value="apply">
							{{ Form::close() }}


					@endif
				</div>

		</div>


</section>


@endsection
