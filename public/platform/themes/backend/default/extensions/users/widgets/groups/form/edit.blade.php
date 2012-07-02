{{ Form::open(ADMIN.'/users/groups/edit/'.$group['id'], 'POST', array('class' => 'form-horizontal')) }}
	
	{{ Form::token() }}
	
	<div class="well">
		<fieldset>

			<label for="name">{{ Lang::line('users::groups.general.name') }}</label>
			<input type="text" id="name" name="name" value="{{ Input::old('name', $group['name']); }}">

		</fieldset>
	</div>

	<button class="btn btn-large" type="submit">{{ Lang::line('users::groups.button.update') }}</button>
	<a class="btn btn-large" href="{{ URL::to_secure(ADMIN.'/users/groups') }}">{{ Lang::line('users::groups.button.cancel') }}</a>
{{ Form::close() }}
