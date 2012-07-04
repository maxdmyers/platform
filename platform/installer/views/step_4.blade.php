@layout('installer::template')

@section('navigation')
	<h1>Administration</h1>
	<p class="step">An account to rule them all</p>
	<div class="breadcrumbs">
		<ul class="nav">
			<li><span>Step 1:</span> Prepare installation</li>
			<li><span>Step 2:</span> Database Credentials</li>
			<li><span>Step 3:</span> Administration</li>
			<li class="active">
				<span>Step 4:</span> Complete
			</li>
		</ul>
	</div>
@endsection

@section('content')
<div class="grid contain">

		<h2>Installation Complete</h2>

		<p class="lead">Congratulations - you've installed Platform! <strong>But wait! Not so fast</strong>, we highly recommend you delete the following folders now that you have completed the installation process.</p>
		<pre><code>platform/installer/*</code></pre>
		<pre><code>public/installer/*</code></pre>
		<div class="actions">
			<p><a href="{{ url(ADMIN) }}" class="btn btn-large">Login to Admin</a> <a href="{{ URL::base() }}" class="btn btn-large">Or visit the Home Page</a></p>
		</div>

</div>

@endsection
