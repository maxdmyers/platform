@foreach ($rows as $row)
	<tr>
		<td>{{ $row['id'] }}</td>
		<td>{{ $row['name'] }}</td>
		<td>{{ $row['slug'] }}</td>
		<td>{{ $row['author'] }}</td>
		<td>{{ $row['description'] }}</td>
		<td>{{ $row['version'] }}</td>
		<td>
			{{ $row['is_core'] ? Lang::line('extensions::extensions.bool.yes') : Lang::line('extensions::extensions.bool.no') }}
		</td>
		<td>
			{{ $row['enabled'] ? Lang::line('extensions::extensions.bool.yes') : Lang::line('extensions::extensions.bool.no') }}
		</td>
		<td>
			@if ($row['enabled'])
				<a href="{{ url(ADMIN.'/extensions/disable/'.$row['id']) }}">disable</a>
			@else
				<a href="{{ url(ADMIN.'/extensions/enable/'.$row['id']) }}">enable</a>
			@endif
		</td>
	</tr>
@endforeach
