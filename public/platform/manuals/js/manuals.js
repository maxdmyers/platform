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
	$('#chapter pre:not(.no-prettyprint)').addClass('prettyprint linenums');
	prettyPrint();


	/*
	|-------------------------------------
	| Editing articles
	|-------------------------------------
	*/

	// Capture tabs in the editor
	if ($().tabby) {
		$('#article-editor').tabby();
	}

	if (typeof Markdown != 'undefined') {

		// Refresh the preview area
		$('#article-preview').bind('refresh', function() {
			$(this).html(Markdown($('#article-editor').val()));
			$('#article-preview table').addClass('table table-bordered table-striped');
			$('#article-preview pre').addClass('prettyprint linenums');
		});

		// Initially prefill the article preview
		$('#article-preview').trigger('refresh');

		// Observe events when typing on the editor
		$('#article-editor').on('focus keyup', function() {
			$('#article-preview').trigger('refresh');
		});

		// Display markup on help
		$('#edit-help .markup').each(function() {
			$(this).closest('.help-section').find('.result').html(Markdown($(this).text()));
		});
		$('#edit-help .result pre').addClass('prettyprint linenums');

		// Finally, call prettyPrint
		prettyPrint();
	}

});
