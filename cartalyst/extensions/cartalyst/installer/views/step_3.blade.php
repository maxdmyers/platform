@layout('installer::template')

@section('content')

<h1>Step 3</h1>

<p>
	This is where we would prompt the user to create their account etc.
</p>

{{ Form::open(null, 'POST', array('class' => 'form-horizontal')) }}

	<fieldset>
		<legend>Create Admin User</legend>

		<div class="control-group">
			<div class="control-group">
			{{ Form::label('first_name', 'First Name', array('class' => 'control-label')) }}
			<div class="controls">
				{{ Form::text('first_name', null, array('placeholder' => 'e.g. John')) }}
			</div>
		</div>
		<div class="control-group">
			<div class="control-group">
			{{ Form::label('last_name', 'Last Name', array('class' => 'control-label')) }}
			<div class="controls">
				{{ Form::text('last_name', null, array('placeholder' => 'e.g. Doe')) }}
			</div>
		</div>
		<div class="control-group">
			<div class="control-group">
			{{ Form::label('email', 'Email', array('class' => 'control-label')) }}
			<div class="controls">
				{{ Form::text('email', null, array('placeholder' => 'e.g. email@example.com')) }}
			</div>
		</div>
		<div class="control-group">
			<div class="control-group">
			{{ Form::label('password', 'Password', array('class' => 'control-label')) }}
			<div class="controls">
				{{ Form::password('password') }}
			</div>
		</div>
		<div class="control-group">
			<div class="control-group">
			{{ Form::label('password_confirmation', 'Confirm Password', array('class' => 'control-label')) }}
			<div class="controls">
				{{ Form::password('password_confirmation') }}
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-primary">
					Finish
				</button>
			</div>
		</div>
	</fieldset>

{{ Form::close() }}

@endsection