@if ($has_settings)
	{{ Form::open(ADMIN.'/settings/general') }}
		<fieldset>
			<legend>{{ Lang::line('settings::settings.general.fieldset.details') }}</legend>

			<div class="control-group">
				<label class="control-label" for="site-name">{{ Lang::line('settings::settings.general.site.name') }}</label>
				<div class="controls">
					<input type="text" id="site-name" name="site:name" value="{{ $settings['site']['name']['value'] }}">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="site-name">{{ Lang::line('settings::settings.general.site.tagline') }}</label>
				<div class="controls">
					<input type="text" id="site-tagline" name="site:tagline" value="{{ $settings['site']['tagline']['value'] }}">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="site-name">{{ Lang::line('settings::settings.general.site.url') }}</label>
				<div class="controls">
					<input type="text" id="site-url" name="site:url" value="{{ $settings['site']['url']['value'] }}">
				</div>
			</div>
		</fieldset>

		<fieldset>
			<legend>{{ Lang::line('settings::settings.general.fieldset.address') }}</legend>

			<div class="control-group">
				<label class="control-label" for="address-name">{{ Lang::line('settings::settings.general.address.name') }}</label>
				<div class="controls">
					<input type="text" id="address-name" name="address:name" value="{{ $settings['address']['name']['value'] }}">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="address-street">{{ Lang::line('settings::settings.general.address.street') }}</label>
				<div class="controls">
					<input type="text" id="address-street" name="address:street" value="{{ $settings['address']['street']['value'] }}">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="address-city">{{ Lang::line('settings::settings.general.address.city') }}</label>
				<div class="controls">
					<input type="text" id="address-city" name="address:city" value="{{ $settings['address']['city']['value'] }}">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="address-state">{{ Lang::line('settings::settings.general.address.state') }}</label>
				<div class="controls">
					<input type="text" id="address-state" name="address:state" value="{{ $settings['address']['state']['value'] }}">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="address-zip">{{ Lang::line('settings::settings.general.address.zip') }}</label>
				<div class="controls">
					<input type="text" id="address-zip" name="site:zip" value="{{ $settings['address']['zip']['value'] }}">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="address-country">{{ Lang::line('settings::settings.general.address.country') }}</label>
				<div class="controls">
					<input type="text" id="address-country" name="site:country" value="{{ $settings['address']['country']['value'] }}">
				</div>
			</div>

		</fieldset>

		<fieldset>
			<legend>{{ Lang::line('settings::settings.general.fieldset.brand') }}</legend>

			<div class="control-group">
				<label class="control-label" for="site-brand">{{ Lang::line('settings::settings.general.site.brand') }}</label>
				<div class="controls">
					<input type="text" id="site-brand" name="site:brand" value="{{ $settings['site']['brand']['value'] }}">
				</div>
			</div>

		</fieldset>

		<input type="submit" value="Update">
	{{ Form::close() }}
@else
	{{ $message }}
@endif
