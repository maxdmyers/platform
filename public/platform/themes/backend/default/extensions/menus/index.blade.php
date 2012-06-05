@layout('templates.template')



@section('title')
	menus.title
@endsection


@section('links')
	{{ Theme::asset('menus::css/menus.css') }}
@endsection




@section('content')

<h3>Menus list</h3>
{{ HTML::link('admin/menus/create', 'Create New Menu') }}
<ul>
	@forelse ($menus as $menu)
		<li>
			{{ HTML::link('admin/menus/edit/'.$menu['id'], $menu['name']) }}
		</li>
	@empty
		<li>
			There are no menus :(
		</li>
	@endforelse
</ul>

@endsection




@section('links')

@endsection




@section('body_scripts')

@endsection
