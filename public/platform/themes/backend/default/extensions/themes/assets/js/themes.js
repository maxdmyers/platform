(function($) {
	//var $activate = $('#activate');
	//var $errors = $('.errors');

	//$('#activate').each(function(index) {

		$('.activate').on('click', function(e) {
			e.preventDefault();
			var self = $(this);
			//alert($(this).attr("href"));
			//$errors.addClass('alert alert-info');
			//$errors.html('Please Wait...');

			$.ajax({
				type:     'POST',
				url:      self.attr("href"),
				dataType: 'json',
				data:     { type: self.attr("data-type"), theme: self.attr("data-theme") },

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
		});
})(jQuery);
