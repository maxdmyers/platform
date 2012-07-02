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
	<header class="head row">
		<div class="span6">
			<h1>{{ $theme['name'] }}</h1>
			<p>{{ $theme['description'] }} by {{ $theme['author'] }} v{{ $theme['version'] }}</p>
		</div>
	</header>

	<hr>

	<div class="theme row">
		<div class="span12">

			@if (count($theme['options']))
				{{ Form::open(null, 'POST', array('id' => 'theme-options', 'class' => 'form-horizontal')) }}
					
					{{ Form::token() }}

					<div class="well">
						<input type="hidden" name="theme" value="{{ $theme['dir'] }}">
						@if (isset($theme['id']))
						<input type="hidden" name="id" value="{{ $theme['id'] }}">
						@endif

						@foreach ($theme['options'] as $id => $option)
						<fieldset>
							<legend>{{ $option['text'] }}</legend>
							@foreach ($option['styles'] as $style => $value)
								<label>{{ $style }}</label>
								<input type="text" name="options[{{$id}}][styles][{{$style}}]" value="{{ $value }}">
							@endforeach
						</fieldset>
						@endforeach
					</div>

		            <button class="btn btn-large" type="submit" name="form_options" value="apply">{{ Lang::line('themes::themes.button.apply') }}</button>
		            <a class="btn btn-large" href="../../{{ URI::segment(4) }}">{{ Lang::line('themes::themes.button.complete') }}</a>

				{{ Form::close() }}

			@else

			<div class="unavailable">
				{{ Lang::line('themes::themes.message.no_options') }}
			</div>

			@endif

		</div>
	</div>

</section>

@endsection
