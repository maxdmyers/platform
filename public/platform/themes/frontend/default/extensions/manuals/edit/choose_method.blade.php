@layout('manuals::templates/manual')

@section('content')

	{{ Form::open('manuals/edit/authorize', 'POST', array('class' => 'form-horizontal article-editor', 'id' => 'article-edit'))}}

		<div class="header-edit">
			<h1>
				Edit Article [{{ $manual }}:{{ $chapter }}:{{ $article_name }}]
			</h1>
		</div>

		<p class="lead">
			Before you continue, you need to select how you wish to edit this article.
		</p>

		<div class="row-fluid">

			<div class="span6">
				<h3>Login With GitHub</h3>
				<img src="{{ Theme::asset('manuals::img/edit/github.png') }}">
				<br>
				{{ HTML::link('manuals/edit/authorize', 'Continue', array('class' => 'btn')) }}
			</div>

			<div class="span6">
				<h3>Edit Anonymously</h3>
			</div>

		</div>

	{{ Form::close() }}

@endsection

@section('body_scripts')
{{ Theme::asset('manuals::js/jquery/tabby-0.12.js') }}
@endsection