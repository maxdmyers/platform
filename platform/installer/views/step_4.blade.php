@layout('installer::template')

@section('content')
<div id="installer">

	<div class="well">
		<div class="brand">
			{{ HTML::image('platform/installer/img/brand.png', 'Platform by Cartalyst'); }}
		</div>

		<div class="step row-fluid">
			<div class="finish span12">
				<h1>Finished!</h1>

				<p>Congratulations - you've installed Platform!</p>

				<a href="{{ url(ADMIN) }}" class="btn btn-primary">Login to Admin</a>
			</div>
		</div>
	</div>
</div>

@endsection
