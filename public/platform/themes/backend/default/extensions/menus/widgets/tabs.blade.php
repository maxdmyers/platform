<ul class="nav nav-tabs">
	@foreach ($items as $item)
		<li class="{{ (($item['uri'] and ends_with(URI::current(), $item['uri'])) or ( ! $item['uri'] and URI::current() == ADMIN)) ? 'active' : null }}">

			{{ HTML::link(ADMIN.'/'.$item['uri'], $item['name']) }}
		</li>
	@endforeach
</ul>
