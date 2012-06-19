@layout('manuals::templates/manual')

@section('header')

	<div class="brand">
		<a href="{{ URL::to('manuals') }}">
			<img src="{{ Theme::asset('manuals::img/brand-icon.png') }}" alt="Platform by Cartalyst">
		</a>
	</div>

	<div id="toc" data-active-chapter="{{ e($active_chapter) }}">
		<img src="{{ Theme::asset('manuals::img/'.$active_manual.'.png') }}" alt="Platform by Cartalyst">

		{{ $toc }}
	</div>
@endsection

@section('content')

	<div class="span2" id="chapter-toc">
		{{ $chapter_toc }}
	</div>
	<div class="span10" id="chapter">


		@forelse ($articles as $article)
			{{ $article }}
		@empty
			No articles.
		@endforelse
	</div>


@endsection
