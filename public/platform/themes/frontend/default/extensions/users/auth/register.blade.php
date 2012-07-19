@layout('templates.blank')

<!--queue styles-->
{{ Theme::queue_asset('auth-forms', 'users::css/auth-forms.less') }}

<!--queue scripts-->
{{ Theme::queue_asset('register', 'users::js/register.js', 'jquery') }}

<!--page title-->
@section('title')
	Platform Register
@endsection

<!--page content-->
@section('content')

<div>
	@widget('platform.users::form.register')
</div>

@endsection
