$(document).ready(function() {

	/*
	|-------------------------------------
	| New menu items
	|-------------------------------------
	|
	| Helpers for when adding new menu
	| items.
	*/
	$('#new-item-name').bind('focus keyup change', function(e) {
		$('#new-item-slug').val($(this).slugify());
	});
});