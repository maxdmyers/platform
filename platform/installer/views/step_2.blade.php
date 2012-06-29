@layout('installer::template')

@section('content')

<div id="installer">
	<div class="content">

		<div class="brand">
			{{ HTML::image('platform/installer/img/brand.png', 'Platform by Cartalyst'); }}
		</div>
		<h1>Administration</h1>
		<p>Setting up your admin account</p>

		<div class="breadcrumbs">
			<ul class="nav">
				<li>{{ HTML::link('installer/step_1', 'Step 1') }}</li>
				<li class="active">Step 2</li>
				<li>Finish</li>
			</ul>
		</div>

		{{ Form::open(null, 'POST', array('class' => 'form-inline')) }}
		<fieldset>

			<div class="control-group">
				{{ Form::label('first_name', 'First Name', array('class' => 'control-label', 'for' => 'inputIcon')) }}
	         	<div class="controls">
	            	<div class="input-prepend">
	            		<span class="add-on"><i class="icon-user"></i></span>{{ Form::text('first_name', null, array('placeholder' => 'e.g. John', 'required')) }}
	            	</div>
	        	</div>
	        </div>

	        <div class="control-group">
				{{ Form::label('last_name', 'Last Name', array('class' => 'control-label', 'for' => 'inputIcon')) }}
	         	<div class="controls">
	            	<div class="input-prepend">
	            		<span class="add-on"><i class="icon-user"></i></span>{{ Form::text('last_name', null, array('placeholder' => 'e.g. Doe', 'required')) }}
	            	</div>
	        	</div>
	        </div>

	        <div class="control-group">
				{{ Form::label('email', 'Email', array('class' => 'control-label', 'for' => 'inputIcon')) }}
	         	<div class="controls">
	            	<div class="input-prepend">
	            		<span class="add-on"><i class="icon-user"></i></span>{{ Form::email('email', null, array('placeholder' => 'e.g. email@example.com', 'required')) }}
	            	</div>
	        	</div>
	        </div>

	        <div class="control-group">
				{{ Form::label('password', 'Password', array('class' => 'control-label', 'for' => 'inputIcon')) }}
	         	<div class="controls">
	            	<div class="input-prepend">
	            		<span class="add-on"><i class="icon-lock"></i></span>{{ Form::password('password', array('required')) }}
	            	</div>
	        	</div>
	        </div>

	        <div class="control-group">
				{{ Form::label('password_confirmation', 'Confirm Password', array('class' => 'control-label', 'for' => 'inputIcon')) }}
	         	<div class="controls">
	            	<div class="input-prepend">
	            		<span class="add-on"><i class="icon-lock"></i></span>{{ Form::password('password_confirmation', array('required')) }}
	            	</div>
	        	</div>
	        </div>

    		<div class="control-group pager">
				<div class="controls">
					<button type="submit" class="btn btn-primary">
						Finish
					</button>
				</div>
			</div>

		</fieldset>
		{{ Form::close() }}

	</div>
</div>

@endsection
