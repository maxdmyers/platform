@layout('installer::template')

@section('content')

<div id="installer">
	<div class="content">

		<div class="brand">
			{{ HTML::image('platform/installer/img/brand.png', 'Platform by Cartalyst'); }}
		</div>
		<h1>Database Credentials</h1>
		<p>First we need to connect to your database.</p>

		<div class="breadcrumbs">
			<ul class="nav">
				<li class="active">Step 1</li>
				<li>Step 2</li>
				<li>Finish</li>
			</ul>
		</div>

		{{ Form::open('installer/step_1', 'POST', array('class' => 'form-inline', 'id' => 'database-form')) }}

			<fieldset>

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
		            		<span class="add-on"><i class="icon-globe"></i></span>{{ Form::text('host', null, array('placeholder' => 'e.g. localhost', 'required')) }}
		            	</div>
		        	</div>
		        </div>

		        <div class="control-group">
					{{ Form::label('username', 'Username', array('class' => 'control-label', 'for' => 'inputIcon')) }}
		         	<div class="controls">
		            	<div class="input-prepend">
		            		<span class="add-on"><i class="icon-user"></i></span>{{ Form::text('username', null, array('placeholder' => 'e.g. root', 'required')) }}
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
		            		<span class="add-on"><i class="icon-briefcase"></i></span>{{ Form::text('database', null, array('placeholder' => 'e.g. platform', 'required')) }}
		            	</div>
		        	</div>
		        </div>

				<div class="control-group pager">
					<div class="controls">
						<button type="submit" class="btn btn-large btn-primary" disabled>
							Continue to Step 2
						</button>
					</div>
				</div>
				<div class="control-group database">
					<div class="controls">
						<div class="confirm-db alert">

						</div>
					</div>
				</div>

				</fieldset>

				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>

@endsection
