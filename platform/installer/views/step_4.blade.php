@layout('installer::template')

@section('content')
<div id="installer">
	<div class="content">

		<div class="brand">
			{{ HTML::image('platform/installer/img/brand.png', 'Platform by Cartalyst'); }}
		</div>
		<h1>All Done :)</h1>
		<p>Congratulations - you've installed Platform!</p>

		<div class="breadcrumbs">
			<ul class="nav">
				<li>Step 1</li>
				<li>Step 2</li>
				<li>Step 3</li>
				<li class="active">Finish</li>
			</ul>
		</div>
		<div class="finish">

			<a href="{{ url(ADMIN) }}" class="btn btn-primary">Login to Admin</a>

		</div>
	</div>
</div>

@endsection
