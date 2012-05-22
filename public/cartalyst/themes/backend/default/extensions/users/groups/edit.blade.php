@layout('templates/template')

@section('title')
	{{ __('users::groups.title_edit') }}
@endsection

@section('content')
	{{ Form::open() }}
		<fieldset>
			<div>
				<label for="name">{{ __('users::groups.name') }}</label>
				<input type="text" id="name" name="name" value="{{ Input::old('name', $group['name']); }}" />
			</div>
			<div>
				<input type="submit" value="{{ __('users::groups.btn_create') }}">
				<a href="{{ url(ADMIN.'/users/groups') }}">{{ __('users::groups.btn_cancel') }}</a>
			</div>
		</fieldset>
	{{ Form::close() }}
@endsection
