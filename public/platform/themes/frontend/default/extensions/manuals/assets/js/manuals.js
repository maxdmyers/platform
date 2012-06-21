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


	/*
	|-------------------------------------
	| Editing articles
	|-------------------------------------
	*/

	// Capture tabs in the editor
	if ($().tabby) {
		$('#article-editor').tabby();
	}

	// Hook into submit function
	$('#article-edit').on('submit', function(e) {
		e.preventDefault();

		// Disable our button
		$('#article-editor').attr('readonly', 'readonly');
		$('#message').attr('readonly', 'readonly');
		$('#article-edit .form-actions .btn').addClass('hide');
		$('#article-edit .loading-indicator').removeClass('hide');

		// AJAX call to save menu
		$.ajax({
			url      : $(this).attr('action'),
			type     : 'POST',
			dataType : 'json',
			data     : $(this).serialize(),
			success  : function(data, textStatus, jqXHR) {
				if ( ! data.status && data.message) {
					alert("An Error Occured:\n\n"+data.message);
				}

				if (data.redirect_uri) {
					window.location.href = data.redirect_uri;
					return;
				}

				$('#article-editor').removeAttr('readonly');
				$('#message').removeAttr('readonly');
				$('#article-edit .form-actions .btn').removeClass('hide');
				$('#article-edit .loading-indicator').addClass('hide');
			},
			error    : function(jqXHR, textStatus, errorThrown) {
				alert(jqXHR.status + ' ' + errorThrown);
			}
		});

		return false;
	});

	/*
	|-------------------------------------
	| Miscellaneous
	|-------------------------------------
	*/

	// Markdown
	if (typeof Markdown != 'undefined') {

		// Refresh the preview area
		$('#article-preview').bind('refresh', function() {
			$(this).html(Markdown($('#article-editor').val()));
			$('#article-preview table').addClass('table table-bordered table-striped');
			$('#article-preview pre:not(.no-prettyprint)').addClass('prettyprint linenums');
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
		$('#edit-help .result pre:not(.no-prettyprint)').addClass('prettyprint linenums');
	}

	// Call prettyprint
	prettyPrint();

});
