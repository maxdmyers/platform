@layout('templates.template')

@section('title')
	{{ Lang::line('users::users.title_create') }}
@endsection

@section('content')
<div>
	@widget('platform.users::form.create')
</div>
@endsection
