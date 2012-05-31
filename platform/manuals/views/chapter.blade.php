@layout('manuals::template')

@section('content')

	<div class="span4" id="toc">
		{{ $toc }}
	</div>

	<div class="span8" id="chapter">
		{{ $chapter_toc }}

		@forelse ($articles as $article)
			{{ $article }}
		@empty
			No articles.
		@endforelse
	</div>


@endsection