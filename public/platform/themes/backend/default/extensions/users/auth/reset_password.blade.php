@layout('templates/blank')

@section('links')
	{{ Theme::asset('users::css/login.less') }}
@endsection

@section('body_scripts')
	{{ Theme::asset('users::js/reset_password.js') }}
@endsection

@section('title')
	Reset Password
@endsection

@section('content')
	<section id="login">

		<img src="{{ Theme::asset('img/brand.png') }}" title="Cartalyst">
		<h1>@get.settings.store.name</h1>
		<h2>{{ Lang::line('users::users.general.reset_password') }}</h2>

		{{ Form::open(null, 'POST', array('id' => 'password-reset-form', 'class' => 'form-horizontal')) }}

			{{ Form::token() }}

			<!-- remove this later when we get errors via js ? -->
			<p class="errors"></p>
			<!-- end remove -->

	    	<input type="email" name="email" id="email" placeholder="{{ Lang::line('users::users.general.email') }}" autocomplete="off">

	    	<div class="input-append">
				<input type="password" name="password" id="password" placeholder="{{ Lang::line('users::users.general.new_password') }}" autocomplet="off"/><button class="btn append" type="submit"/>{{ Lang::line('users::users.button.reset_password') }}</button>
			</div>

			<p class="help-block">{{ Lang::line('users::users.general.reset_help') }}</p>

		{{ Form::close() }}

	</section>
@endsection
