<div style="margin-left: 0.5%; float: left; width: 32%;">
	{{ $toc }}
</div>

<div style="margin-right: 0.5%; float: right; width: 62%;">
	{{ $chapter_toc }}

	@forelse ($articles as $article)
		{{ $article }}
	@empty
		No articles.
	@endforelse
</div>