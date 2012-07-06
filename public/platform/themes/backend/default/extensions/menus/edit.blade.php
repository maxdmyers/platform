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
	{{ Theme::asset('menus::js/menussortable-1.0.js') }}

	<script>
	$(document).ready(function() {

		$('#platform-menu').menuSortable({

			// Array of ALL existing
			// slugs. Just so we don't
			// have any clashes
			persistedSlugs : {{ $persisted_slugs }},

			// Define Nesty Sortable dependency for the menu sortable.
			nestySortable: {
				fields           : [
					{
						name        : 'name',
						newSelector : '#new-item-name'
					},
					{
						name        : 'slug',
						newSelector : '#new-item-slug'
					},
					{
						name        : 'uri',
						newSelector : '#new-item-uri'
					},
					{
						name        : 'secure',
						newSelector : '#new-item-secure'
					}
				],
				itemTemplate         : {{ $item_template }},
				lastItemId           : {{ $last_item_id }}
			}
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

		{{ Form::open(ADMIN.'/menus/edit/'.$menu_id ?: null, 'POST', array('id' => 'platform-menu', 'autocomplete' => 'off', 'novalidate')) }}
			
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

									<div class="control-group">
										{{ Form::label('new-item-name', Lang::line('menus::menus.general.name')) }}
										{{ Form::text(null, null, array('class' => 'input-block-level', 'id' => 'new-item-name', 'placeholder' => Lang::line('menus::menus.general.name'), 'required')) }}
									</div>

									<div class="control-group">
										{{ Form::label('new-item-slug', Lang::line('menus::menus.general.slug')) }}
										{{ Form::text(null, null, array('class' => 'input-block-level item-slug', 'id' => 'new-item-slug', 'placeholder' => Lang::line('menus::menus.general.slug'), 'required')) }}
									</div>

									<div class="control-group">
										{{ Form::label('new-item-uri', Lang::line('menus::menus.general.uri')) }}
										{{ Form::text(null, null, array('class' => 'input-block-level', 'id' => 'new-item-uri', 'placeholder' => Lang::line('menus::menus.general.uri'), 'required')) }}

										<label class="checkbox">
											{{ Form::checkbox(null, 1, false, array('id' => 'new-item-secure')) }}
											{{ Lang::line('menus::menus.general.secure') }}
										</label>
									</div>

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
						{{ Form::text('name', isset($menu['name']) ? $menu['name'] : null, array('id' => 'menu-name', 'placeholder' => Lang::line('menus::menus.general.name'), (isset($menu['user_editable']) and ! $menu['user_editable']) ? 'disabled' : 'required')) }}

						{{ Form::label('menu-slug', Lang::line('menus::menus.general.slug')) }}
						{{ Form::text('slug', isset($menu['slug']) ? $menu['slug'] : null, array('id' => 'menu-slug', 'placeholder' => Lang::line('menus::menus.general.slug'), (isset($menu['user_editable']) and ! $menu['user_editable']) ? 'disabled' : 'required')) }}

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