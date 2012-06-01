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
		<pre>
			{{ print_r($rules) }}
		</pre>
{{ Form::close() }}
