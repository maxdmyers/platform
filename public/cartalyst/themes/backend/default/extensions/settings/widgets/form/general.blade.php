@if ($has_settings)
	<fieldset>
		<legend>{{ Lang::line('settings::settings.general_fieldset_store_details') }} and {{ $settings['store_name']['value'] }}</legend>

		<div class="control-group">
			<label class="control-label" for="store-name">{{ Lang::line('settings::settings.general_store_name') }}</label>
			<div class="controls">
				<input type="text" id="store-name" name="store_name" value="{{ $settings['store_name']['value'] }}">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="store-name">{{ Lang::line('settings::settings.general_store_tagline') }}</label>
			<div class="controls">
				<input type="text" id="store-tagline" name="store_tagline" value="{{ $settings['store_tagline']['value'] }}">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="store-name">{{ Lang::line('settings::settings.general_store_url') }}</label>
			<div class="controls">
				<input type="text" id="store-url" name="store_url" value="{{ $settings['store_url']['value'] }}">
			</div>
		</div>
	</fieldset>

	<fieldset>
		<legend>{{ Lang::line('settings::settings.general_fieldset_store_address') }}</legend>

		<div class="control-group">
			<label class="control-label" for="store-name">{{ Lang::line('settings::settings.general_store_name') }}</label>
			<div class="controls">
				<input type="text" id="store-name" name="store_name" value="{{ $settings['store_name']['value'] }}">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="store-street">{{ Lang::line('settings::settings.general_store_street') }}</label>
			<div class="controls">
				<input type="text" id="store-street" name="store_street" value="{{ $settings['store_street']['value'] }}">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="store-street">{{ Lang::line('settings::settings.general_store_street') }}</label>
			<div class="controls">
				<input type="text" id="store-street" name="store_street" value="{{ $settings['store_street']['value'] }}">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="store-city">{{ Lang::line('settings::settings.general_store_city') }}</label>
			<div class="controls">
				<input type="text" id="store-city" name="store_city" value="{{ $settings['store_city']['value'] }}">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="store-state">{{ Lang::line('settings::settings.general_store_state') }}</label>
			<div class="controls">
				<input type="text" id="store-state" name="store_state" value="{{ $settings['store_state']['value'] }}">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="store-zip">{{ Lang::line('settings::settings.general_store_zip') }}</label>
			<div class="controls">
				<input type="text" id="store-zip" name="store_zip" value="{{ $settings['store_zip']['value'] }}">
			</div>
		</div>

	</fieldset>

	<fieldset>
		<legend>{{ Lang::line('settings::settings.general_fieldset_store_brand') }}</legend>

		<div class="control-group">
			<label class="control-label" for="store-brand">{{ Lang::line('settings::settings.general_store_brand') }}</label>
			<div class="controls">
				<input type="text" id="store-brand" name="store_brand" value="{{ $settings['store_brand']['value'] }}">
			</div>
		</div>

	</fieldset>
@else
	{{ $message }}
@endif
