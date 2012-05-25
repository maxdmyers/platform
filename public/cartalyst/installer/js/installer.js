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
	$('#database-form').find('select, input').bind('focus keyup change', function(e) {

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
				url      : '/installer/index/confirm_db',
				data     : $('#database-form').serialize(),
				dataType : 'JSON',
				success  : function(data, textStatus, jqXHR) {

					// Show success message and enable continue button
					$('.confirm-db').html(data.message)
					                [data.error ? 'addClass' : 'removeClass']('alert-error')
					                [data.error ? 'removeClass' : 'addClass']('alert-success')
					                .show();

					$('#database-form button:submit')[data.error ? 'attr' : 'removeAttr']('disabled', 'disabled');
				},
				error    : function(jqXHR, textStatus, errorThrown) {
					alert(jqXHR.status + ' ' + errorThrown);
				}
			})
		}

		// Else, remove the confirm database text
		// and disable the continue button
		else {
			$('.confirm-db').html('')
			                .hide();

			$('#database-form button:submit').attr('disabled', 'disabled');
		}
	});
});
