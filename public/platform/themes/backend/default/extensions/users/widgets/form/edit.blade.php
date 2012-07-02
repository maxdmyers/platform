{{ Form::open(ADMIN.'/users/edit/'.$user['id'], 'POST', array('class' => 'form-horizontal')) }}

	{{ Form::token() }}

	<div class="well">
		<fieldset>

			<label for="first_name">{{ Lang::line('users::users.general.first_name') }}</label>
			<input type="text" id="first_name" name="first_name" value="{{ Input::old('metadata.first_name', $user['metadata']['first_name']); }}">

			<label for="last_name">{{ Lang::line('users::users.general.last_name') }}</label>
			<input type="text" id="last_name" name="last_name" value="{{ Input::old('metadata.last_name', $user['metadata']['last_name']); }}">

			<label for="email">{{ Lang::line('users::users.general.email') }}</label>
			<input type="text" id="email" name="email" value="{{ Input::old('email', $user['email']); }}">


			<label for="password">{{ Lang::line('users::users.general.password') }}</label>
			<input type="password" id="password" name="password">

			<label for="password_confirmation">{{ Lang::line('users::users.general.password_confirmation') }}</label>
			<input type="password" id="password_confirmation" name="password_confirmation">

			<label for="groups">{{ Lang::line('users::users.general.groups') }}</label>
			{{ Form::select('groups[]', $user_groups, $user['groups'], array('multiple' => 'multiple')) }}

		</fieldset>
	</div>

	<button class="btn btn-large" type="submit" value="{{ Lang::line('users::users.button.create') }}">{{ Lang::line('users::users.button.update') }}</button>
	<a class="btn btn-large" href="{{ URL::to_secure(ADMIN.'/users') }}">{{ Lang::line('users::users.button.cancel') }}</a>
{{ Form::close() }}
