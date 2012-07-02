{{ Form::open() }}

	{{ Form::token() }}

	<fieldset>
		<div>
			<label for="name">{{ Lang::line('users::groups.general.name') }}</label>
			<input type="text" id="name" name="name" value="{{ Input::old('name'); }}">

		</div>
		<div>
			<button class="btn btn-large" type="submit">{{ Lang::line('users::groups.button.create') }}</button>
			<a class="btn btn-large" href="{{ URL::to_secure(ADMIN.'/users/groups') }}">{{ Lang::line('users::groups.button.cancel') }}</a>
		</div>
	</fieldset>
{{ Form::close() }}
