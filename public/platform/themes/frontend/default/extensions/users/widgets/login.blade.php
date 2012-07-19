<div id="auth">
	{{ Form::open('login', 'POST', array('id' => 'login-form', 'class' => 'form-horizontal')) }}

		{{ Form::token() }}

		<input type="email" name="email" id="email" placeholder="{{ lang::line('users::users.general.email') }}" autocomplete="off">
		<input type="password" name="password" id="password" placeholder="{{ lang::line('users::users.general.password') }}" autocomplete="off">
		<button class="btn" type="submit">{{ Lang::line('users::users.button.login') }}</button>

		<p class="help-block"><a href="{{ URL::to_secure('/reset_password') }}">{{ Lang::line('users::users.general.reset_password') }}</a></p>
	{{ Form::close() }}

	<p class="errors"></p>

</div>
