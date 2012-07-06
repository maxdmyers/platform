<li data-item="item_{{ $item['id'] }}">

	<div class="item">

		<header class="item-header">
			<span class="item-sort"><i class="icon-move"></i></span> {{ $item['name'] }} <span class="item-toggle-details"><i class="icon-edit"></i></span>
		</header>

		<section class="clearfix item-details">

			<div class="form-horizontal well">
				{{ Form::hidden('item_fields['.$item['id'].'][is_new]', 0) }}

				<div class="control-group">
					{{ Form::label('menu-items-'.$item['id'].'-name', Lang::line('menus::menus.general.name')) }}
					{{ Form::text('item_fields['.$item['id'].'][name]', $item['name'], array('id' => 'menu-items-'.$item['id'].'-name', 'placeholder' => Lang::line('menus::menus.general.name'), ( ! $item['user_editable']) ? 'disabled' : 'required')) }}
				</div>

				<div class="control-group">
					{{ Form::label('menu-items-'.$item['id'].'-slug', Lang::line('menus::menus.general.slug')) }}
					{{ Form::text('item_fields['.$item['id'].'][slug]', $item['slug'], array('id' => 'menu-items-'.$item['id'].'-slug', 'placeholder' => Lang::line('menus::menus.general.slug'), 'class' => 'item-slug', ( ! $item['user_editable']) ? 'disabled' : 'required')) }}
				</div>

				<div class="control-group">
					{{ Form::label('menu-items-'.$item['id'].'-uri', Lang::line('menus::menus.general.uri')) }}
					{{ Form::text('item_fields['.$item['id'].'][uri]', $item['uri'], array('id' => 'menu-items-'.$item['id'].'-uri', 'placeholder' => Lang::line('menus::menus.general.uri'), ( ! $item['user_editable']) ? 'disabled' : 'required', 'class' => 'item-uri')) }}
				</div>

				<div class="control-group">
					<label class="checkbox">
						{{ Form::checkbox('item_fields['.$item['id'].'][secure]', 1, (bool) $item['secure'], array('class' => 'item-secure', ( ! $item['user_editable'] or URL::valid($item['uri'])) ? 'disabled' : null)) }}
						{{ Lang::line('menus::menus.general.secure') }}
					</label>
				</div>

				<div class="control-group">
					{{ Form::label('menu-items-'.$item['id'].'-status', Lang::line('menus::menus.general.status')) }}
					{{ Form::select('item_fields['.$item['id'].'][status]', array(1 => Lang::line('menus::menus.general.yes'), 0 => Lang::line('menus::menus.general.no')), $item['status'], array('id' => 'menu-items-'.$item['id'].'-status', ( ! $item['user_editable']) ? 'disabled' : 'required')) }}
				</div>

			</div>

			<hr>

			<button class="pull-right btn btn-danger btn-mini item-remove" {{ ( ! $item['user_editable']) ? 'disabled' : null }}>
				{{ Lang::line('menus::menus.button.remove_item'.(( ! $item['user_editable']) ? '_disabled' : null))}}
			</button>

		</section>

	</div>

	@if ($item['children'])
		<ol>

			@foreach ($item['children'] as $child)
				@render('menus::edit.item', array('item' => $child))
			@endforeach

		</ol>
	@endif

</li>