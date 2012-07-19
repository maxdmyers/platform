@layout('templates.blank')

<!--queue styles-->
{{ Theme::queue_asset('login', 'users::css/auth-forms.less') }}

<!--queue scripts-->
{{ Theme::queue_asset('login', 'users::js/login.js', 'jquery') }}

<!--page title-->
@section('title')
	Platform Login
@endsection

<!--page content-->
@section('content')

<div>
	@widget('platform.users::form.login')
</div>

@endsection
