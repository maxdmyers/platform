@layout('installer::template')

@section('navigation')
	<h1>Database</h1>
	<p class="step">Let's take some database credentials</p>
	<div class="breadcrumbs">
		<ul class="nav">
			<li><span>Step 1:</span> Prepare installation</li>
			<li class="active">
				<span>Step 2:</span> Database Credentials
				<div class="messages alert"></div>
			</li>
			<li><span>Step 3:</span> Administration</li>
			<li><span>Step 4:</span> Complete</li>
		</ul>
	</div>
@endsection


@section('content')
<div class="grid contain">
	<h2>Now its time to create a database, then give us the details and we'll do the rest.</h2>
	{{ Form::open(null, 'POST', array('id' => 'database-form')) }}
	{{ Form::token() }}
	<fieldset>
		{{ Form::select('driver', array(null => 'Database Driver') + $drivers, $credentials['driver'], array('class' => 'span3')) }}
		{{ Form::text('host', $credentials['host'], array('class' => 'span3', 'placeholder' => 'Server', 'required')) }}
		{{ Form::text('username', $credentials['username'], array('class' => 'span3', 'placeholder' => 'User Name', 'required')) }}
		{{ Form::password('password', array('class' => 'span3', 'placeholder' => 'Password')) }}
		{{ Form::text('database', $credentials['database'], array('class' => 'span3', 'placeholder' => 'Database Name', 'required')) }}
	</fieldset>
	<div class="actions">
		<a class="btn btn-large" href="{{URL::to('installer/step_1');}}">Back</a>
		<button type="submit" class="btn btn-large" disabled>
			Continue to Step 3
		</button>
	</div>
	{{ Form::close() }}
</div>
@endsection
