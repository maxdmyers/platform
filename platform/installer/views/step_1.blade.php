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
					<li class="active">Step 1</li>
					<li>Step 2</li>
					<li>Step 3</li>
					<li>Finish</li>
				</ul>
			</div>
		</div>

		<div class="step row-fluid">
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
					{{ Form::label('username', 'Username', array('class' => 'control-label', 'for' => 'inputIcon')) }}
		         	<div class="controls">
		            	<div class="input-prepend">
		            		<span class="add-on"><i class="icon-user"></i></span>{{ Form::text('username', null, array('placeholder' => 'e.g. root')) }}
		            	</div>
		        	</div>
		        </div>

		        <div class="control-group">
					{{ Form::label('password', 'Password', array('class' => 'control-label', 'for' => 'inputIcon')) }}
		         	<div class="controls">
		            	<div class="input-prepend">
		            		<span class="add-on"><i class="icon-lock"></i></span>{{ Form::password('password', array('placeholder' => '')) }}
		            	</div>
		        	</div>
		        </div>

		        <div class="control-group">
					{{ Form::label('database', 'Database', array('class' => 'control-label', 'for' => 'inputIcon')) }}
		         	<div class="controls">
		            	<div class="input-prepend">
		            		<span class="add-on"><i class="icon-briefcase"></i></span>{{ Form::text('database', null, array('placeholder' => 'e.g. platform')) }}
		            	</div>
		        	</div>
		        </div>

		        <div class="control-group database">
					<div class="controls">
						<div class="confirm-db alert">

						</div>
					</div>
				</div>

		        <div class="control-group pager">
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
</div>

@endsection
