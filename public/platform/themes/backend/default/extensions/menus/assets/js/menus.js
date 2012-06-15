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
});