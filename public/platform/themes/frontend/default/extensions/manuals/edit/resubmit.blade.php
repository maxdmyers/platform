@layout('manuals::templates.blank')

@section('content')

	{{ Form::open('manuals/edit/'.$manual.'/'.$chapter.'/'.$article_name, 'POST', array('style' => 'visibility: hidden; height: 0;', 'id' => 'form')) }}

		{{ Form::textarea('article', $article) }}
		{{ Form::hidden('message', $message) }}

	{{ Form::close() }}

@endsection

@section('body_scripts')

	<script>
		var form = document.getElementById('form');
		form.submit();
	</script>

@endsection