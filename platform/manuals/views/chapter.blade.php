@layout('manuals::template')

@section('header')

	<div class="brand">
		<a href="{{ URL::to('manuals') }}">
			{{ HTML::image('platform/manuals/img/brand-icon.png', 'Platform by Cartalyst'); }}
		</a>
	</div>

	<div id="toc" data-active-chapter="{{ e($active_chapter) }}">
		{{ HTML::image('platform/manuals/img/'. URI::segment(2) . '.png', 'Platform by Cartalyst'); }}

		{{ $toc }}
	</div>
@endsection

@section('navigation')

@endsection

@section('content')

	<div class="span2" id="chapter-toc">
		{{ $chapter_toc }}
	</div>
	<div class="span8" id="chapter">


		@forelse ($articles as $article)
			{{ $article }}
		@empty
			No articles.
		@endforelse
	</div>


@endsection
