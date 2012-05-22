<ul class="nav nav-list">
	@foreach ($items as $item)
		<li>
			{{ HTML::link(ADMIN.'/'.$item['uri'], $item['name']) }}

			<pre>{{ print_r($item) }}</pre>

			@if ($item['children'])
				<ul>
					@foreach ($item['children'] as $child)
						<li>
							{{ HTML::link(ADMIN.'/'.$child['uri'], $child['name']) }}
						</li>
					@endforeach
				</ul>
			@endif
		</li>
	@endforeach
</ul>