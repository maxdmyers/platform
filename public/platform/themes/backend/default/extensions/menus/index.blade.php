@layout('templates.template')

@section('title')
	{{ Lang::line('menus::menus.general.title') }}
@endsection

@section('links')
	{{ Theme::asset('menus::css/menus.less') }}
@endsection

@section('content')

	<header class="head row">
		<div class="span4">
			<h1>{{ Lang::line('menus::menus.title') }}</h1>
			<p>{{ Lang::line('menus::menus.tagline') }}</p>
		</div>
	</header>

	<div class="actions clearfix">
		<div id="table-filters" class="form-inline pull-left"></div>
		<div class="pull-right">
			{{ HTML::link_to_secure(ADMIN.'/menus/create', Lang::line('menus::menus.button.create'), array('class' => 'btn btn-large btn-primary')) }}
		</div>
	</div>

	<div class="row">
		<div class="span12">

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
								{{ HTML::link_to_secure('admin/menus/edit/'.$menu['id'], 'Edit', array('class' => 'btn')) }}

								@if ($menu['user_editable'])
									{{ HTML::link_to_secure('admin/menus/delete/'.$menu['id'], 'Delete', array('class' => 'btn btn-danger', 'onclick' => 'return confirm(\'Are you sure you want to delete this menu? This cannot be undone.\');')) }}
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

		</div>
	</div>

@endsection




@section('links')

@endsection




@section('body_scripts')

@endsection
