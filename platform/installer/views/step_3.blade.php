@layout('installer::template')

@section('navigation')
	<h1>Administration</h1>
	<p class="step">An account to rule them all</p>
	<div class="breadcrumbs">
		<ul class="nav">
			<li><span>Step 1:</span> Prepare installation</li>
			<li><span>Step 2:</span> Database Credentials</li>
			<li class="active">
				<span>Step 3:</span> Administration
				<div class="messages alert"></div>
			</li>
			<li><span>Step 4:</span> Complete</li>
		</ul>
	</div>
@endsection


@section('content')
<div class="grid contain">
	<h2>Now you need an administrator, create your initial user and your almost ready to rock.</h2>
	{{ Form::open(null, 'POST', array('id' => 'user-form')) }}
	{{ Form::token() }}
	<fieldset>

			{{ Form::text('first_name', null, array('class' => 'span3', 'placeholder' => 'First Name', 'required')) }}
			{{ Form::text('last_name', null, array('class' => 'span3', 'placeholder' => 'Last Name', 'required')) }}
	        {{ Form::email('email', null, array('class' => 'span3', 'placeholder' => 'Email Address', 'required')) }}
	        {{ Form::password('password', array('class' => 'span3', 'placeholder' => 'Password', 'required')) }}
	        {{ Form::password('password_confirmation', array('class' => 'span3', 'placeholder' => 'Confirm Password', 'required')) }}

	</fieldset>
	<div class="actions">
		<button type="submit" class="btn btn-large" disabled>
			Continue to Step 4
		</button>
	</div>
	{{ Form::close() }}
</div>
@endsection
