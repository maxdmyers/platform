@layout('manuals::template')

@section('header')
	<div class="brand">
		<a href="{{ URL::to('manuals') }}">
			{{ HTML::image('platform/manuals/img/brand-icon.png', 'Platform by Cartalyst'); }}
		</a>
	</div>

	<!--<div class="navigation">
		<ul class="nav nav-pills">
			@foreach ($manuals as $folder => $name)
				<li class="{{ $folder === $active_manual ? 'active' : null }}">
					{{ HTML::link('manuals/'.$folder, $name) }}
				</li>
			@endforeach
		</ul>
	</div>-->
@endsection

@section('navigation')

@endsection

@section('content')

	<div class="span2" id="toc">
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
