
(function($) {
	cartalyst.table.init($('#groups-table'), {
		'url': cartalyst.url.admin('users/groups'),
		'searchAll'        : true,
		'liveSearch'       : true,
		'liveSearchDelay'  : 1,

		// text
		'processingText'   : 'Processing...',
		'filterText'       : 'Filter:',
		'addFilterText'    : 'Add Filter'
	});
})(jQuery);
