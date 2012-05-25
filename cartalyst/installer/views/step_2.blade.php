@layout('installer::template')

@section('content')
<div id="installer" class="row-fluid">
  <div class="span12 well">
    <h1>Step 2</h1>

<p>
	This is where we would let the user choose the extensions they wish to install by default. We would show the required extensions but not let them get unticked, but still let all other extensions be unticked.
</p>

<p>
	We need some sort of dependencies system for Cartalyst so that extensions can declare how they might be dependent on others. For example, the Products extension might be switched off by someone who wants Cartalyst as a CMS only, but the Products extension requires the attributes extension.
</p>

{{ Form::open() }}

	<fieldset>
		<legend>Extensions Form</legend>
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
