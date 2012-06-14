@layout('installer::template')

@section('content')
<div id="installer">
	<div class="content">

		<div class="brand">
			{{ HTML::image('platform/installer/img/brand.png', 'Platform by Cartalyst'); }}
		</div>
		<h1>An Extra Step</h1>
		<p>Step 2 is just for you &hearts;</p>

		<div class="breadcrumbs">
			<ul class="nav">
				<li>Step 1</li>
				<li class="active">Step 2</li>
				<li>Step 3</li>
				<li>Finish</li>
			</ul>
		</div>

  		{{ Form::open() }}
		<fieldset>

			<legend>Custom Installation Step</legend>

			<p>Add any custom steps to your installation process</p>

			<div class="control-group pager">
				<div class="controls">
					<button type="submit" class="btn btn-primary">
						Continue to Step 3
					</button>
				</div>
			</div>
		</fieldset>
		{{ Form::close() }}

	</div>
</div>

@endsection
