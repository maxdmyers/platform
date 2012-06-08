<ul class="nav nav-pills nav-stacked">
	@foreach ($items as $item)
		<li class="{{ starts_with(str_replace(ADMIN.'/', null, URI::current()), $item['uri']) ? 'active' : null }}">
			{{ HTML::link(ADMIN.'/'.$item['uri'], $item['name']) }}
		</li>
	@endforeach
</ul>
