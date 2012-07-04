$(document).ready(function() {

	/*
	|-------------------------------------
	| New menu items
	|-------------------------------------
	|
	| Helpers for when adding new menu
	| items.
	*/
	$('#new-item-name').on('focus keyup change', function(e) {
		$('#new-item-slug').val($(this).slugify());
	});

	$('#new-item-uri').on('focus keyup change', function(e) {

		// Full URL, disable the chekcbox
		if (isFullUrl($(this).val())) {
			$('#new-item-secure').attr('disabled', 'disabled');
			$('#new-item-secure')[isSecureUrl($(this).val()) ? 'attr' : 'removeAttr']('checked', 'checked');
		}

		// Relative, give option
		else {

			$('#new-item-secure').removeAttr('disabled');
		}
	});

	/*
	|-------------------------------------
	| Menu itself
	|-------------------------------------
	|
	| Helpers for when editing the menu
	| options
	*/
	$('#menu-name').on('focus keyup change', function(e) {
		$('#menu-slug').val($(this).slugify());
	});

	/*
	|-------------------------------------
	| Secure menu items
	|-------------------------------------
	|
	| Allows for easy setup of the secure
	| menu items.
	*/
	$('body').on('focus keyup change', '.menu-item-uri', function(e) {

		var $secure = $(this).closest('.item').find('.menu-item-secure');

		// Full URL
		if (isFullUrl($(this).val())) {
			$secure.attr('disabled', 'disabled');
			$secure[isSecureUrl($(this).val()) ? 'attr' : 'removeAttr']('checked', 'checked');
		}

		// Relative URI
		else {
			$secure.removeAttr('disabled');
		}
	});

	/**
	 * Tests a URL to see if it's a full
	 * url
	 *
	 * @param   string  uri
	 * @return  bool
	 */
	function isFullUrl(uri) {
		return /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/.test(uri);
	}

	/**
	 * Tests a URL to see if it's secure
	 *
	 * @param   string  uri
	 * @return  bool
	 */
	function isSecureUrl(uri) {
		return /https:\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/.test(uri);
	}
});