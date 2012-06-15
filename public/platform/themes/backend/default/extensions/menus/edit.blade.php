@layout('templates.template')

@section('title')
	menus.title
@endsection

@section('links')
	{{ Theme::asset('menus::css/menus.less') }}
@endsection

@section('body_scripts')
	{{ Theme::asset('js/bootstrap/bootstrap-tab.js') }}
	{{ Theme::asset('js/jquery/ui-1.8.18.min.js') }}
	{{ Theme::asset('menus::js/jquery/nestedsortable-1.3.4.js') }}
	{{ Theme::asset('menus::js/platformmenu.js') }}

	<script>
	$(document).ready(function() {

		// Nesty Sortable
		$('#platform-menu').nestySortable({
			sortableSelector : '.platform-menu',
			fields           : [
				{
					name        : 'name',
					newSelector : '#new-item-name',
					required    : true
				},
				{
					name        : 'slug',
					newSelector : '#new-item-slug',
					required    : true
				},
				{
					name        : 'uri',
					newSelector : '#new-item-uri',
					required    : true
				}
			],
			itemTemplate         : {{ $item_template }},
			lastItemId           : {{ $last_item_id }},
			invalidFieldCallback : function(field, value) {
				alert('Field [' + field.name + '] is required.');
			},
		});
	});
	</script>
@endsection

@section('content')

<section id="menus-edit">

	<header class="head row">
		<div class="span4">
			<h1>Edit Menu</h1>
			<p>Blah blah blah</p>
		</div>
	</header>

	<hr>

	{{ Form::open(ADMIN.'/menus/edit/'.$menu_id ?: null, 'POST', array('id' => 'platform-menu')) }}

		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li class="{{ ($menu_id) ? 'active' : null }}"><a href="#menus-edit-items" data-toggle="tab">Items</a></li>
				<li class="{{ ( ! $menu_id) ? 'active' : null }}"><a href="#menus-edit-menu-options" data-toggle="tab">Menu Options</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane {{ ($menu_id) ? 'active' : null }}" id="menus-edit-items">

					<div class="clearfix">
						<a class="pull-right btn items-toggle-all">Toggle All <i class="icon-edit"></i></a>
					</div>

					<div class="clearfix">

						<div class="platform-new-item">

							<div class="well">

								<h3>New Menu Item</h3>
								<hr>

								{{ Form::label('new-item-name', 'Name') }}
								{{ Form::text(null, null, array('class' => 'input-block-level', 'id' => 'new-item-name', 'placeholder' => 'Name')) }}

								{{ Form::label('new-item-slug', 'Slug') }}
								{{ Form::text(null, null, array('class' => 'input-block-level', 'id' => 'new-item-slug', 'placeholder' => 'Slug')) }}

								{{ Form::label('new-item-uri', 'Uri') }}
								{{ Form::text(null, null, array('class' => 'input-block-level', 'id' => 'new-item-uri', 'placeholder' => 'Uri')) }}

								<hr>

								<button type="button" class="btn btn-small btn-primary items-add-new">Add Item</button>

							</div>

						</div>

						<ol class="platform-menu">
							@if ($menu['children'])
								@foreach ($menu['children'] as $child)
									@render('menus::edit.item', array('item' => $child))
								@endforeach
							@endif
						</ol>

					</div>

				</div>
				<div class="tab-pane {{ ( ! $menu_id) ? 'active' : null }}" id="menus-edit-menu-options">
					
					{{ Form::label('menu-name', 'Name') }}
					{{ Form::text('name', isset($menu['name']) ? $menu['name'] : null, array('id' => 'menu-name', 'placeholder' => 'Name')) }}

					{{ Form::label('menu-slug', 'Slug') }}
					{{ Form::text('slug', isset($menu['slug']) ? $menu['slug'] : null, array('id' => 'menu-slug', 'placeholder' => 'Slug')) }}

				</div>
			</div>
		</div>

		<div class="form-actions">

			<button type="submit" class="btn btn-primary btn-save-menu">
				{{ $menu_id ? 'Save' : 'Create' }} Menu
			</button>

			{{ HTML::link(ADMIN.'/menus', $menu_id ? 'Back' : 'Cancel', array('class' => 'btn')) }}

		</div>

	{{ Form::close() }}

</section>

@endsection