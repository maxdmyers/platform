@layout('manuals::templates/manual')

@section('content')

	{{ Form::open('manuals/edit/'.$manual.'/'.$chapter.'/'.$article_name, 'POST', array('class' => 'form-horizontal article-editor'))}}


		<div class="header-edit">
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
					<textarea name="article" rows="20" class="editor" id="article-editor">{{ $article }}</textarea>
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

		<fieldset>
			<legend>Summarize Your Changes</legend>

			<div class="control-group">
				{{ Form::label('message', 'Message', array('class' => 'control-label')) }}
				<div class="controls">
					{{ Form::text('message', null, array('class' => 'input-xxlarge', 'placeholder' => 'e.g. Added more examples to the configuration.', 'maxlength' => 160)) }}
				</div>
			</div>
		</fieldset>

		<div class="form-actions">
			<button type="submit" class="btn btn-primary">Save changes</button>
			{{ HTML::link('manuals/'.$manual.'/'.$chapter, 'Cancel', array('class' => 'btn'))}}
		</div>

		@include('manuals::edit/help')

	{{ Form::close() }}

@endsection
