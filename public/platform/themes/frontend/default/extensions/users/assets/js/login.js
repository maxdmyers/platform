(function($) {
	var $form = $('#login-form');
	var $errors = $('.errors');
	$form.on('submit', function(e) {
		e.preventDefault();

		$errors.addClass('alert alert-info');
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
					$errors.removeClass('alert-info');
					$errors.addClass('alert-' + data.alert);
					$errors.html(data.message);
				}
			}
		});

		return false;
	});
})(jQuery);
