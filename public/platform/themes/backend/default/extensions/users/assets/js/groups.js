
(function($) {
	platform.table.init($('#groups-table'), {
		'url': platform.url.admin('users/groups'),
		'searchAll'        : true,
		'liveSearch'       : true,
		'liveSearchDelay'  : 1,

		// text
		'processingText'   : 'Processing...',
		'filterText'       : 'Filter:',
		'addFilterText'    : 'Add Filter'
	});
})(jQuery);
