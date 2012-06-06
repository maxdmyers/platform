<ul class="nav nav-tabs">
	@foreach ($items as $item)
		<li class="{{ ends_with(URI::current(), $item['uri']) ? 'active' : null }}">
			{{ HTML::link(ADMIN.'/'.$item['uri'], $item['name']) }}
		</li>
	@endforeach
</ul>
