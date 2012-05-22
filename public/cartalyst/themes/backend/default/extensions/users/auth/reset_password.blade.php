@layout('templates/blank')

@section('body_scripts')
	@parent
	{{ Theme::asset('users::js/reset_password.js') }}
@endsection

@section('title')
	Reset Password
@endsection

@section('content')
	<section id="login">

		<img src="{{ Theme::asset('img/brand.png') }}" title="Cartalyst" />
		<h1>cartalyst.settings.general.store_name</h1>
		<h2>{{ __('users::users.reset_password') }}</h2>

		{{ Form::open(null, 'POST', array('id' => 'password-reset-form', 'class' => 'form-horizontal')) }}

			<!-- remove this later when we get errors via js ? -->
			<p class="errors"></p>
			<!-- end remove -->

	    	<input type="email" name="email" id="email" placeholder="{{ __('users::users.email') }}" autocomplete="off" />

	    	<div class="input-append">
				<input type="password" name="password" id="password" placeholder="{{ __('users::users.new_password') }}" autocomplet="off"/><button class="btn append" type="submit"/>{{ __('users::users.btn_reset_password') }}</button>
			</div>

			<p class="help-block">An email will be sent with instructions.</p>

		{{ Form::close() }}

	</section>
@endsection
