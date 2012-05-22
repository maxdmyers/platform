@foreach ($rows as $row)
	<tr>
		<td>{{ $row['id'] }}</td>
		<td>{{ $row['name'] }}</td>
		<td><a href="{{ url(ADMIN.'/users/groups/edit/'.$row['id']) }}">edit</a> | <a href="{{ url(ADMIN.'/users/groups/delete/'.$row['id']) }}">delete</a></td>
	</tr>
@endforeach
