$(document).ready(function() {

	/*
	|-------------------------------------
	| Enhance side navigation (manual TOC)
	|-------------------------------------
	*/
	$('#toc ul').addClass('nav nav-list');

	/*
	|-------------------------------------
	| Tables
	|-------------------------------------
	*/
	$('#chapter table').addClass('table table-bordered table-striped');

	/*
	|-------------------------------------
	| Prettify code
	|-------------------------------------
	*/
	$('pre').addClass('prettyprint linenums');
	prettyPrint();

});
