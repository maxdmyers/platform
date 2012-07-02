@layout('templates/blank')

@section('links')
	{{ Theme::asset('users::css/login.less') }}
@endsection

@section('body_scripts')
	{{ Theme::asset('users::js/login.js') }}
@endsection

@section('title')
	Login
@endsection

@section('content')
	<section id="login">

		<img src="{{ Theme::asset('img/brand.png') }}" title="Cartalyst">
		<h1>@get.settings.site.title</h1>

		{{ Form::open(null, 'POST', array('id' => 'login-form', 'class' => 'form-horizontal')) }}

			{{ Form::token() }}

			<input type="email" name="email" id="email" placeholder="{{ lang::line('users::users.general.email') }}" autocomplete="off">

			<div class="input-append">
				<input type="password" name="password" id="password" placeholder="{{ lang::line('users::users.general.password') }}" autocomplete="off"><button class="btn append" type="submit">{{ Lang::line('users::users.button.login') }}</button>
			</div>

			<p class="help-block"><a href="{{ URL::to_secure(ADMIN.'/reset_password') }}">{{ Lang::line('users::users.general.reset_password') }}</a></p>

		{{ Form::close() }}

		<p class="errors"></p>

	</section>
@endsection
