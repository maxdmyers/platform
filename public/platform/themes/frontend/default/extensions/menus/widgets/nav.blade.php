<ul class="{{ $class }}">
	@foreach ($items as $item)
		<li>
			@render('menus::widgets.nav.item', array('item' => $item, 'active_path' => $active_path, 'before_uri' => $before_uri))
		</li>
	@endforeach
</ul>