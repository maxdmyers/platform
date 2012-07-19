<div id="auth">
	{{ Form::open('reset_password', 'POST', array('id' => 'password-reset-form', 'class' => 'form-horizontal')) }}

		{{ Form::token() }}

	    	<input type="email" name="email" id="email" placeholder="{{ Lang::line('users::users.general.email') }}" autocomplete="off">

	    	<input type="password" name="password" id="password" placeholder="{{ Lang::line('users::users.general.new_password') }}" autocomplet="off"/>

	    	<button class="btn" type="submit"/>{{ Lang::line('users::users.button.reset_password') }}</button>

			<p class="help-block">{{ Lang::line('users::users.general.reset_help') }}</p>

		{{ Form::close() }}

	<p class="errors"></p>

</div>
