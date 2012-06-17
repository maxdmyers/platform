@layout('installer::template')

@section('content')
<div id="installer">
	<div class="content">

		<div class="brand">
			{{ HTML::image('platform/installer/img/brand.png', 'Platform by Cartalyst'); }}
		</div>
		<h1>Installation Complete</h1>

		<p class="lead">Congratulations - you've installed Platform! <strong>But wait! Not so fast</strong>, we highly recommend you delete the following folders now that you have completed the installation process.</p>
		<pre><code>platform/installer/*</code></pre>
		<pre><code>public/installer/*</code></pre>

		<div class="finish">
			<p><a href="{{ url(ADMIN) }}" class="btn btn-large">Login to Admin</a> <a href="{{ URL::base() }}" class="btn btn-large">Or visit the Home Page</a></p>

		</div>
	</div>
</div>

@endsection
