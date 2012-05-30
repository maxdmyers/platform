@layout('installer::template')

@section('content')
<div id="installer">

	<div class="well">
		<div class="brand">
			{{ HTML::image('platform/installer/img/brand.png', 'Platform by Cartalyst'); }}
		</div>

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

	  		{{ Form::open() }}
			<fieldset>

				<legend>Custom Installation Step</legend>

				<p>
					This is where you would add any custom steps to your installation process
				</p>

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
