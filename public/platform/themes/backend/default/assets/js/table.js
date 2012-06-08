// Just incase the files get loaded out of order
if (platform == undefined)
{
	var platform = { };
}

(function($, window, document, undefined) {

	// define Table object
	platform.table = {

		// Initialize Table
		init: function(elem, options) {
			var self = this;

			// set options
			self.options = $.extend({}, platform.table.options, options);

			// make sure url is set - (remove and default to current url?)
			if (self.options.url === null) {
				alert('Url is required');
				return;
			}

			// grab / create needed elements and bind events
			self.getElements(elem);
			self.bindEvents();

			// init data
			self.initData();
		},

		// make ajax call and display processing feedback
		fetch: function() {
			var self = this;

			// show overlay and processing block
			self.$overlay.css('display', 'block');
			self.$process.css('display', 'block');

			// make ajax call and populate table when it's returned

			//extraData = '&'+$.param(self.options.extraData);
			data = $.param(self.data) + '&' + $.param(self.options.extraData);

			return $.ajax({
				url: self.options.url,
				dataType: 'json',
				data: data,
				cache: false
			}).done(function(results) {
				self.displayData(results);
			}).fail(function(results) {
				self.$overlay.css('display', 'none');
				self.$process.css('display', 'none');
				alert('errors getting data');
			});
		},

		// put new data into table and remove processing feedback
		displayData: function(data) {
			var self = this;
			// hide overlay and processing block
			self.$overlay.css('display', 'none');
			self.$process.css('display', 'none');

			self.$elemBody.html(data.content);
			self.buildPaging(data.paging, data.count_filtered);
		},

		// sets up data for the ajax call
		setData: function(type, append, key, value) {
			var self = this;

			if (type == 'page') {
				self.data[type] = append; // in pages case - append is its value;
				return; // return to pevent the rest from happening
			}

			// sets ordering - needs work for order clicked ?
			if (append) {
				if (value == 'remove') {
					// remove type/key pair
					self.deleteData(type, key);
					self.changePage(1);
				}
				else {
					// set type/key pair to a value
					if (key == 'search_all') {
						if (typeof self.data[type][key] == 'undefined')
						{
							self.data[type][key] = [];
						}
						self.data[type][key].push(value);
					}
					else {
						self.data[type][key] = value;
					}
					self.changePage(1);
				}
			}
			else {
				// delete all current data of certain type
				self.deleteData(type);

				// init that type again since we deleted it
				self.initData(type);

				// if we aren't removing data
				if ( value !== 'remove') {
					// set type/key pair to value
					self.data[type][key] = value;
				}
				self.changePage(1);
			}
		},

		// delete data - idx is for search_all only
		deleteData: function(type, key, idx) {
			var self = this;

			if (typeof type == "undefined") { // delete all data and always re-init
				delete self.data;
				self.initData();
			}
			else if (typeof key == "undefined") { // delete certain type and always re-init
				delete self.data[type];
				self.initData(type);
			}
			else {
				// if its search all
				if (key == 'search_all') {

					// splice off array to keep index consistancy
					self.data[type][key].splice(idx, 1);

					if ( ! self.data[type][key].length) { // if it has no length, remove
						// delete search_all
						delete self.data[type][key];
					}
				}
				else { // otherwise delete normally
					delete self.data[type][key];
				}
			}

		},

		// init data
		initData: function(type) {
			var self = this;

			if (typeof type == "undefined") {
				self.data = {};
				self.data.order_by = {};
				self.data.where = {};
				self.data.live_search = {};
				self.data.page = 1;
			}
			else if (typeof key == "undefined") {
				self.data[type] = {};
			}
		},

		// gets and set all elements needed for script
		getElements: function(elem) {
			var self = this;
			var filterSelect = null;

			// sets element
			self.elem = elem;

			// set jQuery version of element
			self.$elem = $(elem);

			// set table headers and add class sortable
			self.$elemHead = self.$elem
									.find('th[data-table-key]')
									.addClass('sortable');

			// set table body
			self.$elemBody = self.$elem
									.find('tbody');

			// set table wrapper
			self.$wrapper = $('.table-wrapper');

			// set table process div
			self.$process = $('<div class="table-processing"><img src="/platform/themes/backend/default/assets/img/table/loading.gif">'+self.options.processingText+'</div>')
								.prependTo(self.$wrapper);

			// set table overlay dev
			self.$overlay = $('<div class="table-processing-overlay" />')
								.prependTo(self.$wrapper);

			// set opacity for cross browser support
			self.$overlay.css('opacity', self.$overlay.css('opacity'));

			// build filters
			self.buildFilters();

			// pages
			self.$pages = $('#table-pagination');

		},

		// binds all event handlers for script
		bindEvents: function() {
			var self = this;

			// refresh click - temporary?
			self.$refresh.on('click', function(e) {
				e.preventDefault();
				self.fetch();
			});

			/**
			 * Filtering
			 */

			// filter select change
			self.$filterSelect.on('change', function(e) {
				if (self.options.liveSearch && self.$filterText.val()) {
					self.setData('live_search', false, self.$filterSelect.val(), self.$filterText.val());
					self.fetch();
				}
			});

			// live search
			if (self.options.liveSearch) {
				self.$filterText.keyup(function(e) {
					if (typeof(doLiveSearch) != "undefined") {
						clearTimeout(doLiveSearch);
					}
					doLiveSearch = setTimeout(function () {
						if (self.$filterText.val()) {
							self.setData('live_search', false, self.$filterSelect.val(), self.$filterText.val());
						}
						else {
							self.deleteData('live_search');
						}
						self.fetch();
					}, self.options.liveSearchDelay * 1000);
				});
			}

			// add filter
			self.$addFilter.on('click', function(e) {
				e.preventDefault();

				// grab select value and input value
				var text  = self.$filterSelect.find(':selected').text();
				var field = self.$filterSelect.val();
				var value = self.$filterText.val();
				var html = '<div class="table-filter" data-table-filterkey="'+field+'">'+text+' : '+value+'<a href="#" '+self.options.removeFilter.attributes+'>'+self.options.removeFilter.text+'</a></div>';

				if ( value == '' ) {
					return false;
				}

				// reset text value
				self.$filterText.val('');

				// add to data object
				self.setData('where', true, field, value);

				// delete livesearch data
				self.deleteData('live_search');

				// see if filter already exists
				var filterExists = self.$filtersApplied.find('[data-table-filterkey='+field+']');

				// append to filter div
				if ( filterExists.length && field != 'search_all') {
					// delete last filter
					filterExists.remove();
				}

				// append html
				self.$filtersApplied.append(html);

				if (self.options.liveSearch) {
					return; // if live search, we don't need to refetch since the last result is already shown
				}

				self.fetch();
			});

			self.$filtersApplied.on('click', 'a', function(e) {
				e.preventDefault();

				var filter = $(this).parent(),
					key    = filter.attr('data-table-filterkey');

				if (key == 'search_all') {
					idx = filter.index('[data-table-filterkey=search_all]');
					self.deleteData('where', key, idx);
				}
				else {
					// remove from data
					self.deleteData('where', key)
					//delete self.data.where[key];
				}
				// remove from html
				filter.remove();

				self.fetch();
			});



			/**
			 * Sorting
			 */

			// header click
			self.$elemHead.on('click', function(e) {
				e.preventDefault();

				// cache $(this) in $this var
				var $this = $(this);

				// set vars
				var type = 'order_by',
					append = false,
					key = $this.attr('data-table-key'),
					dir = 'asc';

				// if shift is pressed - append
				if (e.shiftKey) {
					append = true;
				}
				else {
					$this.siblings('[data-table-key]').removeClass('sortable-asc sortable-desc').addClass('sortable');
				}

				// check to see if key is in data
				if (self.data[type][key]) {

					if (self.data[type][key] == 'asc') {
						dir = 'desc';
						$this.removeClass('sortable-asc')
							.addClass('sortable-desc');
					}
					else {
						dir = 'remove';
						$this.removeClass('sortable-desc')
							.addClass('sortable');
					}
				}
				else {
					$this.removeClass('sortable')
						.addClass('sortable-asc');
				}

				// set and fetch data
				self.setData(type, append, key, dir);
				self.fetch();
			}).on('selectstart', function(e) {
				e.preventDefault(); // prevents text selection with shift press
			});

			/**
			 * Paging
			 */
			self.$pages.on('click', 'a', function(e) {
				e.preventDefault();
				var $this = $(this);

				if ( ! $this.parent().hasClass('active')) {
					self.changePage($(this).attr('data-table-page'));
					self.fetch();
				}
			});
		},

		buildFilters: function() {
			var self = this;

			self.$filterWrapper = $('#table-filters');

			var select = '<select class="table-filter-select input-medium">';
			if (self.options.searchAll) {
				select += '<option value="search_all">Search All</options>';
			}
			self.$elemHead.each(function(idx) {
				$this = $(this);

				select += '<option value="'+$this.attr('data-table-key')+'">'+$this.text()+'</option>';
			});
			select += '</select>';

			self.$filterSelect   = $(select).appendTo(self.$filterWrapper);
			self.$filterText     = $('<input type="text" class="table-filter-text span3">').appendTo(self.$filterWrapper);
			self.$addFilter      = $('<button class="btn"'+self.options.addFilter.attributes+'>'+self.options.addFilter.text+'</button>').appendTo(self.$filterWrapper);
			self.$refresh        = $('<button class="btn"'+self.options.refresh.attributes+'>'+self.options.refresh.text+'</button>').appendTo(self.$filterWrapper);
			self.$filtersApplied = $('#table-filters-applied');

		},

		buildPaging: function(data, filteredCount) {
			var self = this;

			if ( $.isEmptyObject(self.data.live_search) && $.isEmptyObject(self.data.where) ) {
				self.$pages.html('');
				return;
			}

			var limit  = data.limit,
				offset = data.offset,
				pages  = data.pages,
				html   = '',
				itemCount = 1,
				i      = 1;

			for(i; i <= pages; i++) {
				var start = itemCount;
				var end = itemCount + ( limit - 1 );
				itemCount = end+1;

				var active = (i == self.data.page) ? 'class="active"' : '';

				if (filteredCount <= end) {
					if (i > 1) {
						html += '<li '+active+'><a href="#" data-table-page="'+i+'">'+start+' - '+filteredCount+'</a></li>';
					}
					break;
				}
				else {
					html += '<li '+active+'><a href="#" data-table-page="'+i+'">'+start+' - '+end+'</a></li>';
				}
			}

			self.$pages.html(html);
		},

		changePage: function(page) {
			var self = this;

			self.$pages.find('.active').removeClass('.active');
			self.$pages.find('[data-table-page='+self.data.page+']').parent().addClass('active');

			self.setData('page', page);
		},

	}

	// define plugin options
	platform.table.options = {
		'url'              : null, // string

		// search options
		'searchAll'        : true, // bool
		'liveSearch'       : true, // bool
		'liveSearchDelay'  : 1, // numeric - seconds

		// extra data object
		'extraData' : {},

		// text
		'processingText'   : 'Processing...', // string
		'filterText'       : 'Filter:', // string
		'addFilter'        : {
			'text' : 'Add Filter', // string
			'attributes' : 'id="test" class="btn primary"', // string
		},
		'removeFilter' : {
			'text' : 'remove',
			'attributes' : 'class="btn btn-danger"',
		},
		'refresh' : {
			'text' : 'refresh',
			'attributes' : 'class="btn"',
		}
	};

})(jQuery, window, document);

