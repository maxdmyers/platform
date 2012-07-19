@layout('templates.default')

@section('title')
	{{ Lang::line('users::groups.title_create') }}
@endsection

@section('content')
<div>
	@widget('platform.users::groups.form.create')
</div>
@endsection
