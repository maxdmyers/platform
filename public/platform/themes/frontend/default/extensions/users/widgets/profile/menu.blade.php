<ul class="profile nav nav-pills">

@if ( Sentry::check() and Sentry::user()->has_access('is_admin'))
	<li>
		<a href="{{ URL::to_secure(ADMIN) }}" alt="Admin Dashboard" title="Admin Dashboard">
			<i class="ico-top-admin-dashboard"></i>
			<p>Admin Dashboard</p>
		</a>
	</li>
@endif
@if ( ! Sentry::check())
	<li>
		<a href="{{ URL::to_secure('login') }}" alt="Login" title="Login">
			<i class="ico-top-login"></i>
			<p>Login</p>
		</a>
	</li>
	<li>
		<a href="{{ URL::to_secure('register') }}" alt="Register" title="Register">
			<i class="ico-top-register"></i>
			<p>Register</p>
		</a>
	</li>
@else
	<li>
		<a href="{{ URL::to_secure('profile') }}" alt="Profile" title="Profile">
			<i class="ico-top-profile"></i>
			<p>Profile</p>
		</a>
	</li>
	<li>
		<a href="{{ URL::to_secure('logout') }}" alt="Logout" title="Logout">
			<i class="ico-top-logout"></i>
			<p>Logout</p>
		</a>
	</li>
@endif

</ul>
