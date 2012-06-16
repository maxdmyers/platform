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

<table class="table table-bordered">
	<thead>
		<tr>
			<th>Menu</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@forelse ($menus as $menu)
			<tr>
				<td>
					{{ $menu['name'] }}
				</td>
				<td>
					{{ HTML::link('admin/menus/edit/'.$menu['id'], 'Edit', array('class' => 'btn')) }}

					@if ($menu['user_editable'])
						{{ HTML::link('admin/menus/delete'.$menu['id'], 'Delete', array('class' => 'btn btn-danger', 'onclick' => 'return confirm(\'Are you sure you want to delete this menu? This cannot be undone.\');')) }}
					@endif
				</td>
			</tr>
		@empty
			<tr colspan="2">
				<td>
					No menus yet.
				</td>
			</tr>
		@endforelse
	</tbody>
</table>

<ul class="nav nav-tabs nav-stacked">
	@foreach ($menus as $menu)
		<li>
			
		</li>
	@endforeach
</ul>

@endsection




@section('links')

@endsection




@section('body_scripts')

@endsection
