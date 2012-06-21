@layout('manuals::templates/manual')

@section('content')

	<div class="header-edit">
		<h1>
			How Do You Want to Edit this article?
		</h1>
	</div>

	<p class="lead">
		Before you continue, you need to select how you wish to edit this article.
	</p>

	{{ Form::open('manuals/edit/use', 'POST', array('class' => 'form-horizontal')) }}

		<div class="control-group">
			{{ Form::label('use', 'Edit Method', array('class' => 'control-label')) }}

			<div class="controls">
				<label class="radio">
					{{ Form::radio('use', 'anonymous', true) }}
					Anonymously
				</label>
				<label class="radio">
					{{ Form::radio('use', 'github') }}
					Edit through GitHub
				</label>
			</div>
		</div>

		<div class="form-actions">
			{{ Form::button('Continue', array('class' => 'btn btn-primary')) }}
		</div>

	{{ Form::close() }}

@endsection

@section('body_scripts')
{{ Theme::asset('manuals::js/jquery/tabby-0.12.js') }}
@endsection