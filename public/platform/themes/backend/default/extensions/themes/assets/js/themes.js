(function($) {

	$('.activate').on('click', function(e) {
		e.preventDefault();
		var self = $(this);
		$.ajax({
			type:     'POST',
			url:      self.attr("href"),
			data:     { type: self.attr("data-type"), theme: self.attr("data-theme"), csrf_token: self.attr("data-token") },
			success: function(data) {

					window.location.reload(true);
			}
		});

	});

	// var $form = $('#options-form');
	// var $errors = $('.errors');
	// $form.on('submit', function(e) {
	// 	e.preventDefault();

	// 	$errors.addClass('alert alert-info');
	// 	$errors.html('Please Wait...');

	// 	$.ajax({
	// 		type:     'POST',
	// 		url:      $form.prop('action'),
	// 		dataType: 'json',
	// 		data:     $form.serialize(),

	// 		success: function(data) {
	// 			if(data.status)
	// 			{
	// 				window.location.reload(true);
	// 			}
	// 			else
	// 			{
	// 				alert('wtf');
	// 				$errors.removeClass('alert-info');
	// 				$errors.addClass('alert-' + data.alert);
	// 				$errors.html(data.message);
	// 			}
	// 		}
	// 	});

	// 	return false;
	// });

})(jQuery);
