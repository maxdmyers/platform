@layout('templates.template')

@section('title')
	menus.title
@endsection

@section('links')
	{{ Theme::asset('menus::css/menus.less') }}
@endsection

@section('body_scripts')
	{{ Theme::asset('js/jquery/helpers.js') }}
	{{ Theme::asset('js/bootstrap/bootstrap-tab.js') }}
	{{ Theme::asset('js/jquery/ui-1.8.18.min.js') }}
	{{ Theme::asset('js/jquery/nestedsortable-1.3.4.js') }}
	{{ Theme::asset('js/jquery/nestysortable-1.0.js') }}
	{{ Theme::asset('menus::js/menus.js') }}

	<script>
	$(document).ready(function() {

		// Nesty Sortable
		$('#platform-menu').nestySortable({
			sortableSelector : '.platform-menu',
			ajax             : false,
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
				<h1>{{ Lang::line('menus::menus.update.title') }}</h1>
				<p>{{ Lang::line('menus::menus.update.description') }}</p>
			</div>
		</header>

		<hr>

		{{ Form::open(ADMIN.'/menus/edit/'.$menu_id ?: null, 'POST', array('id' => 'platform-menu', 'autocomplete' => 'off')) }}
			
			{{ Form::token() }}

			<div class="tabbable">
				<ul class="nav nav-tabs">
					<li class="{{ ($menu_id) ? 'active' : null }}"><a href="#menus-edit-items" data-toggle="tab">{{ Lang::line('menus::menus.tabs.items') }}</a></li>
					<li class="{{ ( ! $menu_id) ? 'active' : null }}"><a href="#menus-edit-menu-options" data-toggle="tab">{{ Lang::line('menus::menus.tabs.options') }}</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane {{ ($menu_id) ? 'active' : null }}" id="menus-edit-items">

						<div class="clearfix">
							<a class="pull-right btn items-toggle-all">{{ Lang::line('menus::menus.button.toggle_items_details') }} <i class="icon-edit"></i></a>
						</div>

						<div class="clearfix">

							<div class="platform-new-item">

								<div class="well">

									<h3>{{ Lang::line('menus::menus.general.new_item') }}</h3>
									<hr>

									{{ Form::label('new-item-name', Lang::line('menus::menus.general.name')) }}
									{{ Form::text(null, null, array('class' => 'input-block-level', 'id' => 'new-item-name', 'placeholder' => Lang::line('menus::menus.general.name'))) }}

									{{ Form::label('new-item-slug', Lang::line('menus::menus.general.slug')) }}
									{{ Form::text(null, null, array('class' => 'input-block-level', 'id' => 'new-item-slug', 'placeholder' => Lang::line('menus::menus.general.slug'))) }}

									{{ Form::label('new-item-uri', Lang::line('menus::menus.general.uri')) }}
									{{ Form::text(null, null, array('class' => 'input-block-level', 'id' => 'new-item-uri', 'placeholder' => Lang::line('menus::menus.general.uri'))) }}

									<hr>

									<button type="button" class="btn btn-small btn-primary items-add-new">{{ Lang::line('menus::menus.button.add_item') }}</button>

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
						
						{{ Form::label('menu-name', Lang::line('menus::menus.general.name')) }}
						{{ Form::text('name', isset($menu['name']) ? $menu['name'] : null, array('id' => 'menu-name', 'placeholder' => Lang::line('menus::menus.general.name'), (isset($menu['user_editable']) and ! $menu['user_editable']) ? 'disabled' : null)) }}

						{{ Form::label('menu-slug', Lang::line('menus::menus.general.slug')) }}
						{{ Form::text('slug', isset($menu['slug']) ? $menu['slug'] : null, array('id' => 'menu-slug', 'placeholder' => Lang::line('menus::menus.general.slug'), (isset($menu['user_editable']) and ! $menu['user_editable']) ? 'disabled' : null)) }}

					</div>
				</div>
			</div>

			<div class="form-actions">

				<button type="submit" class="btn btn-primary btn-save-menu">
					{{ Lang::line('menus::menus.button.'.(($menu_id) ? 'update' : 'create')) }}
				</button>

				{{ HTML::link_to_secure(ADMIN.'/menus', Lang::line('menus::menus.button.cancel'), array('class' => 'btn')) }}

			</div>

		{{ Form::close() }}

	</section>
@endsection