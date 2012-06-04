{{ Form::open(ADMIN.'/users/permissions/'.$id) }}
	@foreach($extension_rules as $category)
		<fieldset>
			<legend>{{ $category['title'] }}</legend>
			@foreach($category['permissions'] as $permission)
				<div>
					<label for="{{ $permission['value'] }}" class="checkbox">
						<input type="checkbox" id="{{ $permission['slug'] }}" name="{{ $permission['slug'] }}" {{ ($permission['has']) ? 'checked="checked"' : '' }}> {{ $permission['value'] }}
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
