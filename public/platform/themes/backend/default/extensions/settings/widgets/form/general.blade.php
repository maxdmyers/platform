
	{{ Form::open(ADMIN.'/settings/general') }}
		<fieldset>
			<legend>{{ Lang::line('settings::settings.general.legend') }}</legend>

			<div class="control-group">
				<label class="control-label" for="site-title">{{ Lang::line('settings::settings.general.title') }}</label>
				<div class="controls">
					<input type="text" id="site-title" name="general:title" value="@get.settings.general.title">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="site-tagline">{{ Lang::line('settings::settings.general.tagline') }}</label>
				<div class="controls">
					<input type="text" id="site-tagline" name="general:tagline" value="@get.settings.general.tagline">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="site-email">{{ Lang::line('settings::settings.general.site-email') }}</label>
				<div class="controls">
					<input type="text" id="site-email" name="general:site-email" value="@get.settings.general.site-email">
				</div>
			</div>

		</fieldset>

		<input type="submit" value="Update">
	{{ Form::close() }}
