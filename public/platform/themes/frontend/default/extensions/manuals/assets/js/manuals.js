$(document).ready(function() {

	/*
	|-------------------------------------
	| Enhance navigation (manual TOC)
	|-------------------------------------
	*/
	$('#toc ul').addClass('nav nav-tabs');
	$('#chapter-toc ul').addClass('chapter-nav nav nav-pills nav-stacked');

	// Highlight active chapter
	if ($active = $('#toc').attr('data-active-chapter')) {

		// Look at the URL. Does the last segment (chapter segment)
		// match the chapter we're viewing? If so, that link's parent
		// list item is active.
		$('#toc a').filter(function() {
			var href = $(this).attr('href');

			var re = new RegExp($active, 'i');
			return re.test(    href.substr(href.lastIndexOf('/') + 1)   );
		}).closest('li').addClass('active');
	}

	$('#chapter h3').each(function(index) {
		var name = $(this).html();
		anchor = name.toLowerCase().replace(/\((.*)\)/g, '');
		anchor = anchor.replace(/ /g, "_");
		$(this).attr('id', anchor);
	});


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
		$('#edit-help .result table').addClass('table table-bordered table-striped');
		$('#edit-help .result pre').addClass('prettyprint linenums');

		// Finally, call prettyPrint
		prettyPrint();
	}

});
