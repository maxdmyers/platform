@layout('installer::template')

@section('content')
<div id="installer" class="well">

	<div class="row-fluid">
		<div class="breadcrumbs span12">
			<div class="brand">
	    		{{ HTML::image('cartalyst/installer/img/brand.png', 'Platform by Cartalyst'); }}
	    	</div>
		</div>
	</div>

	<div class="step row-fluid">
	  	<div class="finish span12">



			<h1>Finished!</h1>

			<p>
				Congratulations - you've installed Platform!
			</p>
			<p>
				<a href="{{ url(ADMIN) }}" class="btn btn-primary">
					Login to Admin
				</a>
			</p>
		</div>
	</div>
</div>

@endsection
