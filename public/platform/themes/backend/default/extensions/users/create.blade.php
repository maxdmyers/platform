@layout('templates.template')

@section('title')
	{{ Lang::line('users::users.title_create') }}
@endsection

@section('content')
<div>
	@widget('users::form.create')
</div>
@endsection
