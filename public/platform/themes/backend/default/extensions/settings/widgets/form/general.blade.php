
	{{ Form::open(ADMIN.'/settings/general') }}
		<fieldset>
			<legend>{{ Lang::line('settings::settings.general.title') }}</legend>

			<div class="control-group">
				<label class="control-label" for="site-name">{{ Lang::line('settings::settings.general.name') }}</label>
				<div class="controls">
					<input type="text" id="site-name" name="general:name" value="@get.settings.general.name">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="site-tagline">{{ Lang::line('settings::settings.general.tagline') }}</label>
				<div class="controls">
					<input type="text" id="site-tagline" name="general:tagline" value="@get.settings.general.tagline">
				</div>
			</div>

		</fieldset>

		<input type="submit" value="Update">
	{{ Form::close() }}
