@foreach ($rows as $row)
	<tr>
		<td class="span1">{{ $row['id'] }}</td>
		<td class="span9">{{ $row['name'] }}</td>
		<td class="span2">
			<a class="btn" href="{{ url(ADMIN.'/users/groups/edit/'.$row['id']) }}">edit</a>
			<a class="btn btn-danger" href="{{ url(ADMIN.'/users/groups/delete/'.$row['id']) }}">delete</a>
		</td>
	</tr>
@endforeach
