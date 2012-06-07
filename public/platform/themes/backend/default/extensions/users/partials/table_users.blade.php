@foreach ($rows as $row)
	<tr>
		<td>{{ $row['id'] }}</td>
		<td>{{ $row['metadata']['first_name'] }}</td>
		<td>{{ $row['metadata']['last_name'] }}</td>
		<td>{{ $row['email'] }}</td>
		<td>{{ $row['groups'] }}</td>
		<td>{{ $row['status'] }}</td>
		<td>{{ date('g:ia - F j, Y', $row['created_at']) }}</td>
		<td><a href="{{ url(ADMIN.'/users/edit/'.$row['id']) }}">edit</a> | <a href="{{ url(ADMIN.'/users/delete/'.$row['id']) }}">delete</a></td>
	</tr>
@endforeach
