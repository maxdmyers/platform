{{ Form::open(ADMIN.'/settings/general', 'POST', array('class' => 'form-horizontal')) }}
	<div class="well">
		<fieldset>

			<label for="site-title">{{ Lang::line('settings::settings.general.title') }}</label>
			<input type="text" id="site-title" name="general:title" value="@get.settings.general.title">

			<label for="site-tagline">{{ Lang::line('settings::settings.general.tagline') }}</label>
			<input type="text" id="site-tagline" name="general:tagline" value="@get.settings.general.tagline">

			<label for="site-email">{{ Lang::line('settings::settings.general.site-email') }}</label>
			<input type="text" id="site-email" name="general:site-email" value="@get.settings.general.site-email">

		</fieldset>
	</div>

	<button class="btn btn-large" type="submit" value="{{ Lang::line('users::users.button.create') }}">{{ Lang::line('users::users.button.update') }}</button>
{{ Form::close() }}
