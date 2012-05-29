(function($) {
	var $form = $('#password-reset-form');
	var $errors = $('.errors');
	$form.on('submit', function(e) {
		e.preventDefault();

		$errors.html('Please Wait...');
		$.ajax({
			type:     'POST',
			url:      $form.prop('action'),
			dataType: 'json',
			data:     $form.serialize(),

			success: function(data) {
				if(data.status)
				{
					window.location.href = data.redirect;
				}
				else
				{
					$errors.html(data.message);
				}
			}
		});

		return false;
	});
})(jQuery);
