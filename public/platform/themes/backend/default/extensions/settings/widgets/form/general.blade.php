@if ($has_settings)
	{{ Form::open() }}
		<fieldset>
			<legend>{{ Lang::line('settings::settings.general.fieldset.details') }}</legend>

			<div class="control-group">
				<label class="control-label" for="store-name">{{ Lang::line('settings::settings.general.store.name') }}</label>
				<div class="controls">
					<input type="text" id="store-name" name="store_name" value="{{ $settings['store']['name']['value'] }}">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="store-name">{{ Lang::line('settings::settings.general.store.tagline') }}</label>
				<div class="controls">
					<input type="text" id="store-tagline" name="store_tagline" value="{{ $settings['store']['tagline']['value'] }}">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="store-name">{{ Lang::line('settings::settings.general.store.url') }}</label>
				<div class="controls">
					<input type="text" id="store-url" name="store_url" value="{{ $settings['store']['url']['value'] }}">
				</div>
			</div>
		</fieldset>

		<fieldset>
			<legend>{{ Lang::line('settings::settings.general.fieldset.address') }}</legend>

			<div class="control-group">
				<label class="control-label" for="address-name">{{ Lang::line('settings::settings.general.address.name') }}</label>
				<div class="controls">
					<input type="text" id="address-name" name="address_name" value="{{ $settings['address']['name']['value'] }}">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="address-street">{{ Lang::line('settings::settings.general.address.street') }}</label>
				<div class="controls">
					<input type="text" id="address-street" name="address_street" value="{{ $settings['address']['street']['value'] }}">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="address-city">{{ Lang::line('settings::settings.general.address.city') }}</label>
				<div class="controls">
					<input type="text" id="address-city" name="address_city" value="{{ $settings['address']['city']['value'] }}">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="address-state">{{ Lang::line('settings::settings.general.address.state') }}</label>
				<div class="controls">
					<input type="text" id="address-state" name="address_state" value="{{ $settings['address']['state']['value'] }}">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="address-zip">{{ Lang::line('settings::settings.general.address.zip') }}</label>
				<div class="controls">
					<input type="text" id="address-zip" name="store_zip" value="{{ $settings['address']['zip']['value'] }}">
				</div>
			</div>

		</fieldset>

		<fieldset>
			<legend>{{ Lang::line('settings::settings.general.fieldset.brand') }}</legend>

			<div class="control-group">
				<label class="control-label" for="store-brand">{{ Lang::line('settings::settings.general.store.brand') }}</label>
				<div class="controls">
					<input type="text" id="store-brand" name="store_brand" value="{{ $settings['store']['brand']['value'] }}">
				</div>
			</div>

		</fieldset>

		<input type="submit" value="Update">
	{{ Form::close() }}
@else
	{{ $message }}
@endif
