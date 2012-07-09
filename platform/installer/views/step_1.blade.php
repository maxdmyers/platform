@layout('installer::template')

@section('navigation')
	<h1>Getting Started</h1>
	<p class="step">Preparing for the installation process</p>
	<div class="breadcrumbs">
		<ul class="nav">
			<li class="active"><span>Step 1:</span> Prepare installation</li>
			<li><span>Step 2:</span> Database Credentials</li>
			<li><span>Step 3:</span> Administration</li>
			<li><span>Step 4:</span> Complete</li>
		</ul>
	</div>
@endsection

@section('content')
<div class="grid contain">
	<h2>We'll need to make sure we can write to a few files and directories. After installation, we'll change them back, safe and secure, warm and cozy.</h2>
	{{ Form::open('installer/step_1', 'POST', array('id' => 'writable-form')) }}
		
		{{ Form::token() }}
		
		<div class="files">
			@foreach ($permissions as $path => $value)
				<code class="{{ ($value) ? 'alert alert-success' : 'alert alert-error' }}">{{ $path }}</code>
			@endforeach
		</div>

		<div class="actions">
			<a class="btn btn-large step1-refresh">Refresh</a>
			<button type="submit" class="btn btn-large" {{ $enabled }}>
				Continue to Step 2
			</button>
		</div>
	{{ Form::close() }}
</div>
@endsection
