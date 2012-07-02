<li class="{{ in_array($item['id'], $active_path) ? 'active' : null }}">
	{{ HTML::link_to_secure(((filter_var($item['uri'], FILTER_VALIDATE_URL) === false) ? (($before_uri ? $before_uri.'/' : null)) : null).$item['uri'], $item['name']) }}

	@if ($item['children'])
		<ul>
			@foreach ($item['children'] as $child)
				@render('menus::widgets.nav.item', array('item' => $child, 'active_path' => $active_path, 'before_uri' => $before_uri))
			@endforeach
		</ul>
	@endif
</li>