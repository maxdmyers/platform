{{ Form::open(ADMIN.'/users/groups/edit/'.$group['id']) }}
	<fieldset>
		<div>
			<label for="name">{{ Lang::line('users::groups.name') }}</label>
			<input type="text" id="name" name="name" value="{{ Input::old('name', $group['name']); }}">
		</div>
		<div>
			<input type="submit" value="{{ Lang::line('users::groups.btn_create') }}">
			<a href="{{ url(ADMIN.'/users/groups') }}">{{ Lang::line('users::groups.btn_cancel') }}</a>
		</div>
	</fieldset>
{{ Form::close() }}
