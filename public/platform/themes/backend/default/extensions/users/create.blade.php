@layout('templates/template')

@section('title')
	{{ Lang::line('users::users.title_create') }}
@endsection

@section('content')
	{{ Form::open() }}
		<fieldset>
			<div>
				<label for="first_name">{{ Lang::line('users::users.first_name') }}</label>
				<input type="text" id="first_name" name="first_name" value="{{ Input::old('first_name'); }}">

			</div>
			<div>
				<label for="last_name">{{ Lang::line('users::users.last_name') }}</label>
				<input type="text" id="last_name" name="last_name" value="{{ Input::old('last_name'); }}">
			</div>
			<div>
				<label for="email">{{ Lang::line('users::users.email') }}</label>
				<input type="text" id="email" name="email" value="{{ Input::old('email'); }}">

			</div>
			<div>
				<label for="password">{{ Lang::line('users::users.password') }}</label>
				<input type="password" id="password" name="password">
			</div>
			<div>
				<label for="password_confirmation">{{ Lang::line('users::users.password_confirmation') }}</label>
				<input type="password" id="password_confirmation" name="password_confirmation">
			</div>
			<div>
				<label for="groups">{{ Lang::line('users::users.groups') }}</label>
				{{ Form::select('groups', $groups, null, array('multiple' => 'multiple')) }}
			</div>
			<div>
				<input type="submit" value="{{ Lang::line('users::users.btn_create') }}">
				<a href="{{ url(ADMIN.'/users') }}">{{ Lang::line('users::users.btn_cancel') }}</a>
			</div>
		</fieldset>
	{{ Form::close() }}
@endsection
