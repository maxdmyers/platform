@layout('installer::template')

@section('content')
<div id="installer" class="well">

	<div class="row-fluid">
		<div class="breadcrumbs span12">
			<ul class="nav">
				<li>Step 1</li>
				<li class="active">Step 2</li>
				<li>Step 3</li>
				<li>Finish</li>
			</ul>
		</div>
	</div>

	<div class="step row-fluid">
	  	<div class="left span5">
	  		{{ Form::open() }}

			<fieldset>
				<legend>Custom Installation Step</legend>

			<p>
				This is where you would add any custom steps to your installation process
			</p>


		</div>
		<div class="span7">

			<div class="brand">
				{{ HTML::image('platform/installer/img/brand.png', 'Platform by Cartalyst'); }}
			</div>

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
</div>

@endsection
