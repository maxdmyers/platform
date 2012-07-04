$(document).ready(function() {

	/*
	|-------------------------------------
	| Database form
	|-------------------------------------
	|
	| When the user has filled out all
	| inputs in the database form, we do
	| an ajax call to check the database
	| credentials before allowing them to
	| continue with the install process.
	*/
	$('.messages').html('Awaiting Credentials');

	$('#database-form').find('select, input').on('focus keyup change', function(e) {

		// Check keycode - enter
		// shouldn't trigger it
		if (e.keyCode === 13) {
			return;
		}

		// Count the amount of empty fields
		$length = $('#database-form').find('select, input:not(:password)').filter(function()
		{
			return $(this).val() == '';
		}).length;

		// If we have filled out all fields,
		// do an AJAX call to check the credentials
		if ($length == 0) {

			$.ajax({
				type     : 'POST',
				url      : platform.url.base('installer/confirm_db'),
				data     : $('#database-form').serialize(),
				dataType : 'JSON',
				success  : function(data, textStatus, jqXHR) {

					// Show success message and enable continue button
					$('.messages').html(data.message)
					                [data.error ? 'addClass' : 'removeClass']('alert-error')
					                [data.error ? 'removeClass' : 'addClass']('alert-success')
					                .show();

					$('#database-form button:submit')[data.error ? 'attr' : 'removeAttr']('disabled', 'disabled');
				},
				error    : function(jqXHR, textStatus, errorThrown) {

					// Don't know
					if (jqXHR.status != 0) {
						alert(jqXHR.status + ' ' + errorThrown);
					}
				}
			})
		}

		// Else, remove the confirm database text
		// and disable the continue button
		else {
			$('.messages').html('Awaiting Credentials');

			$('#database-form button:submit').attr('disabled', 'disabled');
		}
	});
});
