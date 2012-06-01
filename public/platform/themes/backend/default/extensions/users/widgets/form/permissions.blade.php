{{ Form::open(ADMIN.'/users/permissions/'.$id) }}
		@foreach($extension_rules as $rules)
			<fieldset>
				<legend>{{ $rules['title'] }}</legend>
				@foreach($rules['values'] as $name => $text)
					<div>
						<label for="{{ $name }}" class="checkbox">
							<input type="checkbox" id="{{ $name }}" name="{{ $name }}"> {{ $text }}
						</label>
					</div>
				@endforeach
			</fieldset>
		@endforeach
		<div>
			<input type="submit" value="{{ Lang::line('users::permissions.btn_update') }}">
			<a href="{{ url(ADMIN.'/users') }}">{{ Lang::line('users::users.btn_cancel') }}</a>
		</div>
{{ Form::close() }}
