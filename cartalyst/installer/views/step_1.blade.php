@layout('installer::template')

@section('content')

<div id="installer" class="row-fluid">
  <div class="span12">
    <h1>Step 1</h1>

    {{ Form::open('installer/index/step_1', 'POST', array('class' => 'form-inline', 'id' => 'database-form')) }}
	<fieldset>
		<legend>Database Credentials</legend>

		<div class="control-group">
			{{ Form::label('driver', 'Driver', array('class' => 'control-label', 'for' => 'inputIcon')) }}
         	<div class="controls">
            	<div class="input-prepend">
            		<span class="add-on"><i class="icon-hdd"></i></span>{{ Form::select('driver', array(null => 'Please Select') + $drivers) }}
            	</div>
        	</div>
        </div>

        <div class="control-group">
			{{ Form::label('host', 'Host', array('class' => 'control-label', 'for' => 'inputIcon')) }}
         	<div class="controls">
            	<div class="input-prepend">
            		<span class="add-on"><i class="icon-globe"></i></span>{{ Form::text('host', null, array('placeholder' => 'e.g. localhost')) }}
            	</div>
        	</div>
        </div>

		<div class="control-group">
			{{ Form::label('username', 'Username', array('class' => 'control-label')) }}
			<div class="controls">
				{{ Form::text('username', null, array('placeholder' => '')) }}
			</div>
		</div>
		<div class="control-group">
			{{ Form::label('password', 'Password', array('class' => 'control-label')) }}
			<div class="controls">
				{{ Form::password('password', array('placeholder' => '')) }}
			</div>
		</div>
		<div class="control-group">
			{{ Form::label('database', 'Database', array('class' => 'control-label')) }}
			<div class="controls">
				{{ Form::text('database', null, array('placeholder' => 'e.g. cartalyst')) }}
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<div id="confirm-db" class="alert">
					sdf
				</div>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<button type="submit" disabled="disabled" class="btn btn-primary">
					Continue to Step 2
				</button>
			</div>
		</div>
	</fieldset>
	{{ Form::close() }}

  </div>
</div>

@endsection
