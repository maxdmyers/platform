@layout('templates/template')

@section('title')
	{{ __('users::users.title_edit') }}
@endsection

@section('content')
	{{ Form::open() }}
		<fieldset>
			<div>
				<label for="first_name">{{ __('users::users.first_name') }}</label>
				<input type="text" id="first_name" name="first_name" value="{{ Input::old('metadata.first_name', $user['metadata']['first_name']); }}" />
			</div>
			<div>
				<label for="last_name">{{ __('users::users.last_name') }}</label>
				<input type="text" id="last_name" name="last_name" value="{{ Input::old('metadata.last_name', $user['metadata']['last_name']); }}" />
			</div>
			<div>
				<label for="email">{{ __('users::users.email') }}</label>
				<input type="text" id="email" name="email" value="{{ Input::old('email', $user['email']); }}" />

			</div>
			<div>
				<label for="password">{{ __('users::users.password') }}</label>
				<input type="password" id="password" name="password" />
			</div>
			<div>
				<label for="password_confirmation">{{ __('users::users.password_confirmation') }}</label>
				<input type="password" id="password_confirmation" name="password_confirmation" />
			</div>
			<div>
				<label for="groups">{{ __('users::users.groups') }}</label>
				{{ Form::select('groups', $user_groups, $user['groups'], array('multiple' => 'multiple')) }}
			</div>
			<div>
				<input type="submit" value="{{ __('users::users.btn_create') }}">
				<a href="{{ url(ADMIN.'/users') }}">{{ __('users::users.btn_cancel') }}</a>
			</div>
		</fieldset>
	{{ Form::close() }}
@endsection
