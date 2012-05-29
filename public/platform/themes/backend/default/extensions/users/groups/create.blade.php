@layout('templates/template')

@section('title')
	{{ Lang::line('users::groups.title_create') }}
@endsection

@section('content')
	{{ Form::open() }}
		<fieldset>
			<div>
				<label for="name">{{ Lang::line('users::groups.name') }}</label>
				<input type="text" id="name" name="name" value="{{ Input::old('name'); }}">

			</div>
			<div>
				<input type="submit" value="{{ Lang::line('users::groups.btn_create') }}">
				<a href="{{ url(ADMIN.'/users/groups') }}">{{ Lang::line('users::groups.btn_cancel') }}</a>
			</div>
		</fieldset>
	{{ Form::close() }}
@endsection
