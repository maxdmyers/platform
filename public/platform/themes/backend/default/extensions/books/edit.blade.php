@layout('templates.template')

@section('title')
	{{ Lang::line('books::books.'.($book_id ? 'update' : 'create').'.title') }}
@endsection

@section('body_scripts')
	{{ Theme::asset('js/bootstrap/bootstrap-tab.js') }}
@endsection

@section('content')
<section id="books-edit">

	<header class="head row">
		<div class="span4">
			<h1>{{ Lang::line('books::books.'.($book_id ? 'update' : 'create').'.title') }}</h1>
			<p>{{ Lang::line('books::books.'.($book_id ? 'update' : 'create').'.description') }}</p>
		</div>
	</header>

	<hr>

	{{ Form::open() }}

		<div class="well">

			<fieldset>

				{{ Form::label('title', Lang::line('books::books.general.book_title')) }}
				{{ Form::text('title', Input::old('title', array_get($book, 'title')), array('placeholder' => Lang::line('books::books.general.book_title'))) }}

				{{ Form::label('author', Lang::line('books::books.general.author')) }}
				{{ Form::text('author', Input::old('author', array_get($book, 'author')), array('placeholder' => Lang::line('books::books.general.author'))) }}

				{{ Form::label('description', Lang::line('books::books.general.book_description')) }}
				{{ Form::textarea('description', Input::old('description', array_get($book, 'description')), array('placeholder' => Lang::line('books::books.general.book_description'))) }}

				{{ Form::label('image', Lang::line('books::books.general.image')) }}
				{{ Form::text('image', Input::old('image', array_get($book, 'image')), array('placeholder' => Lang::line('books::books.general.image'))) }}

				{{ Form::label('link', Lang::line('books::books.general.link')) }}
				{{ Form::url('link', Input::old('link', array_get($book, 'link')), array('placeholder' => Lang::line('books::books.general.link'))) }}

				{{ Form::label('price', Lang::line('books::books.general.price')) }}

				<div class="controls">
					<div class="input-prepend">
						<span class="add-on">$</span>
						{{ Form::number('price', Input::old('price', array_get($book, 'price')), array('placeholder' => Lang::line('books::books.general.price'), 'min' => 0, 'step' => '0.50', 'class' => 'input-small')) }}
					</div>
				</div>

			</fieldset>

		</div>

		<div class="form-actions">
			{{ Form::button(Lang::line('books::books.button.'.(($book_id) ? 'update' : 'create')), array('class' => 'btn btn-primary')) }}
			{{ HTML::link(ADMIN.'/books', 'Cancel', array('class' => 'btn')) }}
		</div>

	{{ Form::close() }}
	
</section>
@endsection
