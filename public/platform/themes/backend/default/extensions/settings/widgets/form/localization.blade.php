<fieldset>
	<legend>Localization</legend>


	<div class="control-group">
		<label class="control-label" for="store-brand">{{ Lang::line('settings::settings.localization_country') }}</label>
		<div class="controls">
			<select>
				@foreach (countries as country)
	                <option>{{ country }}</option>
                @endforeach
			</select>
		</div>
	</div>

</fieldset>
