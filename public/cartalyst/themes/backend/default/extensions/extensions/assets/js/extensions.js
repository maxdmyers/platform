
(function($) {
	cartalyst.table.init($('#installed-extension-table'), {
		'url': cartalyst.url.admin('extensions'),
		'searchAll'        : true,
		'liveSearch'       : true,
		'liveSearchDelay'  : 1,

		// text
		'processingText'   : 'Processing...',
		'filterText'       : 'Filter:',
		'addFilterText'    : 'Add Filter'
	});
})(jQuery);
