<li data-item="item_{{ $item['id'] }}">

	<div class="item">

		<header class="item-header">
			<span class="item-sort"><i class="icon-move"></i></span> {{ $item['name'] }} <span class="item-toggle-details"><i class="icon-edit"></i></span>
		</header>

		<section class="clearfix item-details">

			<div class="form-inline well">
				{{ Form::hidden('item_fields['.$item['id'].'][is_new]', 0) }}

				{{ Form::label('menu-items-'.$item['id'].'-name', 'Name') }}
				{{ Form::text('item_fields['.$item['id'].'][name]', $item['name'], array('id' => 'menu-items-'.$item['id'].'-name', 'placeholder' => 'Name', ( ! $item['user_editable']) ? 'disabled' : null)) }}

				{{ Form::label('menu-items-'.$item['id'].'-slug', 'Slug') }}
				{{ Form::text('item_fields['.$item['id'].'][slug]', $item['slug'], array('id' => 'menu-items-'.$item['id'].'-slug', 'placeholder' => 'Slug', ( ! $item['user_editable']) ? 'disabled' : null)) }}

				{{ Form::label('menu-items-'.$item['id'].'-uri', 'Uri') }}
				{{ Form::text('item_fields['.$item['id'].'][uri]', $item['uri'], array('id' => 'menu-items-'.$item['id'].'-uri', 'placeholder' => 'Uri', ( ! $item['user_editable']) ? 'disabled' : null)) }}
			</div>

			<hr>

			<button class="pull-right btn btn-danger btn-mini item-remove" {{ ( ! $item['user_editable']) ? 'adisabled' : null }}>
				{{ ($item['user_editable']) ? 'Remove Item' : 'Required - Cannot Remove' }}
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