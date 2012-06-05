@layout('templates.template')

@section('title')
	{{ Lang::line('users::groups.title_create') }}
@endsection

@section('content')
<div>
	@widget('users::groups.form.create')
</div>
@endsection
