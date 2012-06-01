@layout('manuals::template')

@section('content')

	<div class="article-editor">

		<div class="page-header">
			<h1>
				Edit Article [{{ $manual }}:{{ $chapter }}:{{ $article_name }}]
			</h1>
		</div>

		<div class="row-fluid">
			
			<div class="span6">
				<a class="btn pull-right" data-toggle="modal" href="#edit-help" >Need Help?</a>
				<h2>
					Markdown Editor
				</h2>
				<div class="well">
					<textarea rows="20" class="editor" id="article-editor">{{ $article }}</textarea>
				</div>
			</div>

			<div class="span6">
				<h2>
					Preview
				</h2>
				<div class="well">
					<article class="preview" id="article-preview"></article>
				</div>
			</div>

		</div>

		@include('manuals::edit/help')

	</div>

@endsection