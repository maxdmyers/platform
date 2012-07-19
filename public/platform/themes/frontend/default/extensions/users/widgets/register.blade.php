<div id="auth">
	{{ Form::open('register', 'POST', array('id' => 'register-form', 'class' => 'form-horizontal')) }}

		{{ Form::token() }}

		<input type="text" id="first-name" name="first_name" value="{{ Input::old('first_name') }}" placeholder="{{ lang::line('users::users.general.first_name') }}">
		<input type="text" id="last-name" name="last_name" value="{{ Input::old('last_name') }}" placeholder="{{ lang::line('users::users.general.last_name') }}">
		<input type="text" id="email" name="email" value="{{ Input::old('email') }}" placeholder="{{ lang::line('users::users.general.email') }}">
		<input type="text" id="email-confirm" name="email_confirm" placeholder="{{ lang::line('users::users.general.email_confirmation') }}">
		<input type="password" id="password" name="password" placeholder="{{ lang::line('users::users.general.password') }}" autocomplete="off">
		<input type="password" id="password-confirm" name="password_confirm" placeholder="{{ lang::line('users::users.general.password_confirmation') }}" autocomplete="off">

		<button class="btn" type="submit">{{ Lang::line('users::users.button.register') }}</button>

	{{ Form::close() }}

	<p class="errors"></p>

</div>
