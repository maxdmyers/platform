@layout('templates.template')

@section('title')
	{{ Lang::line('menus::menus.general.title') }}
@endsection

@section('links')
	{{ Theme::asset('menus::css/menus.less') }}
@endsection

@section('content')

<div class="clearfix page-header">
	<h1 class="pull-left">Menus</h1>

	{{ HTML::link('admin/menus/create', 'Create New Menu', array('class' => 'btn btn-primary pull-right')) }}
</div>

<ul class="nav nav-tabs nav-stacked">
	@foreach ($menus as $menu)
		<li>
			{{ HTML::link('admin/menus/edit/'.$menu['id'], "'{$menu['name']}' Menu") }}
		</li>
	@endforeach
</ul>

@endsection




@section('links')

@endsection




@section('body_scripts')

@endsection
