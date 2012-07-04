@foreach ($installed as $row)
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
			@if ( ! $row['is_core'])

				@if ($row['enabled'])
					<a class="btn" href="{{ URL::to_secure(ADMIN.'/extensions/disable/'.$row['id']) }}" onclick="return confirm('Are you sure you want to disable the \'{{ e($row['name']) }}\' extension? All of its data will stay safe in your database, however it won\'t be available to use while disabled.');">disable</a>
				@else
					<a class="btn" href="{{ URL::to_secure(ADMIN.'/extensions/enable/'.$row['id']) }}" onclick="return confirm('Are you sure you want to enable the \'{{ e($row['name']) }}\' extension?');">enable</a>
				@endif

				@if ($row['update'])
					<a class="btn" href="{{ URL::to_secure(ADMIN.'/extensions/update/'.$row['id']) }}" onclick="return confirm('Are you sure you want to update the \'{{ e($row['name']) }}\' extension?');">update</a>
				@endif

				| <a class="btn btn-danger" href="{{ URL::to_secure(ADMIN.'/extensions/uninstall/'.$row['id']) }}" onclick="return confirm('Are you sure you want to uninstall the \'{{ e($row['name']) }}\' extension? All traces, including database info will be removed permanently. There is no undo action for this.');">uninstall</a>

				

			@else
				Required
			@endif
		</td>
	</tr>
@endforeach
