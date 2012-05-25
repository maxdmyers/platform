@layout('installer::template')

@section('content')

<h1>Finished!</h1>

<p>
	Congratulations - you've installed Cartalyst Platform!
</p>
<p>
	<a href="{{ url(ADMIN) }}" class="btn btn-primary">
		Login to Admin
	</a>
</p>

@endsection