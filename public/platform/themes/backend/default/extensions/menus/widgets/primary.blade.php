<ul class="nav nav-pills nav-stacked">
	@foreach ($items as $item)
		<li>
			{{ HTML::link(ADMIN.'/'.$item['uri'], $item['name']) }}

			<!-- @if ($item['children'])
				<ul>
					@foreach ($item['children'] as $child)
						<li>
							{{ HTML::link(ADMIN.'/'.$child['uri'], $child['name']) }}
						</li>
					@endforeach
				</ul>
			@endif -->
		</li>
	@endforeach
</ul>
