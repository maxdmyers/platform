<div id="{{ $article_name }}">
	<a style="float: right;" href="{{ URL::to('manuals/edit/'.$manual.'/'.$chapter.'/'.$article_name) }}">
		Edit
	</a>
	{{ $article }}
</div>