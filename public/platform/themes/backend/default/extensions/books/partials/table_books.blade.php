@foreach ($rows as $row)
	<tr>
		<td class="span1">{{ $row['id'] }}</td>
		<td class="span2">{{ $row['title'] }}</td>
		<td class="span1">{{ $row['author'] }}</td>
		<td class="span1">{{ $row['description'] }}</td>
		<td class="span1">{{ $row['year'] }}</td>
		<td class="span2">
			<a class="btn" href="{{ URL::to_secure(ADMIN.'/books/edit/'.$row['id']) }}">edit</a>
			<a class="btn btn-danger" href="{{ URL::to_secure(ADMIN.'/books/delete/'.$row['id']) }}">delete</a>
		</td>
	</tr>
@endforeach
