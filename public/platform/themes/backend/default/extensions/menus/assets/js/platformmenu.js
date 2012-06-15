(function() {

	/**
	 * @todo make the new item fields more dynamic
	 */

	// CartMenu plugin
	var PlatformMenu = {

		// Settings
		settings : {

			/**
			 * Selectors for a new 
			 * menu item
			 */
			newItemSelectors : {
				name : '.new-item-name',
				uri  : '.new-item-uri',
				slug : '.new-item-slug',
				add  : '.new-item-add'
			},

			// Menu selector
			menuSelector: '.actual-menu',

			// Save selector
			saveSelector: '.save-menu',

			// Item selectors
			itemSelectors: {
				wrapper : 'div',
				handle  : 'header',
				toggle  : '.toggle',
				details : 'section'
			},

			// Menu identifier
			menuId: null,

			// Item template
			itemTemplate: '',

			// Last item identifier
			lastItemId: 0,

			/**
			 * Menu save URI - must be provided
			 * to construct
			 */
			saveUri: false
		},

		// Element
		elem : null,

		// Menu object
		menu : null,

		init : function(elem, settings) {
			var self  = this;
			self.elem = elem;

			// Override default settings
			$.extend(self.settings, settings);

			// Setup menu
			self.setupMenu();

			// Observe new items
			self.observeNewItems();

			// Observe items
			self.observeItems();

			// Observe save
			self.observeSave();
		},

		// Sets up the menu
		setupMenu: function() {
			var self  = this;
			var elem  = self.elem;
			var menu  = elem.find(self.settings.menuSelector);
			self.menu = menu;

			menu.nestedSortable({
				disableNesting       : 'no-nest',
				forcePlaceholderSize : true,
				handle               : 'div header',
				helper               :'clone',
				items                : 'li',
				maxLevels            : 0,
				opacity              : .6,
				placeholder          : 'placeholder',
				revert               : 250,
				tabSize              : 25,
				tolerance            : 'pointer',
				toleranceElement     : '> div'
			});

			// Observe changes
			self.observeMenuChanges();

			return this;
		},

		// Observe menu changes
		observeMenuChanges: function() {
			var self = this;
			var elem = self.elem;
			var menu = self.menu;
		},

		// Observe new items
		observeNewItems: function() {
			var self      = this;
			var elem      = self.elem;
			var selectors = self.settings.newItemSelectors;

			/**
			 * When user adds a new item
			 */
			elem.find(selectors.add).on('click', function() {

				$name = elem.find(selectors.name);
				$slug = elem.find(selectors.slug);
				$uri  = elem.find(selectors.uri);

				self.addMenuItem($name.val(), $slug.val(), $uri.val());
				$name.val('');
				$uri.val('');

				return false;
			});

			return this;
		},

		/**
		 * Add a new menu item
		 * 
		 * @param  string  name
		 * @param  string  uri
		 * @return PlatformMenu
		 */
		addMenuItem: function(name, slug, uri) {

			if (name.length == 0 || uri.length == 0) {
				return alert('Fill out all fields.');
			}

			var self         = this;
			var elem         = self.elem;
			var menu         = self.menu;
			var id           = self.settings.lastItemId  + 1;
			var itemTemplate = self.settings.itemTemplate;

			// Update our template with real vars
			itemTemplate = itemTemplate.replace(/\{\{id\}\}/gi, id)
			                           .replace(/\{\{name\}\}/gi, name)
			                           .replace(/\{\{slug\}\}/gi, name)
			                           .replace(/\{\{uri\}\}/gi, uri);

			// Append our item
			menu.append(itemTemplate);

			// Increase the last item id
			self.settings.lastItemId += 1;

			return this;
		},

		observeItems: function() {
			var self = this;
			var elem = self.elem;
			var itemSelectors = self.settings.itemSelectors;

			/**
			 * We're using this selector so we observe any
			 * newly created menu items as well
			 */
			$('body').on('click', elem.selector + ' ' + itemSelectors.wrapper + ' ' + itemSelectors.toggle, function() {
				$wrapper = $(this).closest(itemSelectors.wrapper);
				$wrapper.find(itemSelectors.details).slideToggle('fast');
			});
		},

		observeSave: function() {
			var self         = this;
			var elem         = self.elem;
			var saveSelector = self.settings.saveSelector;
			var saveUri      = self.settings.saveUri;
			var menuId       = self.settings.menuId;
			var menu         = self.menu;

			// When the user clicks the save button
			elem.find(saveSelector).on('click', function() {

				/**
				 * We combine both the data about the
				 * order of the menu and the inputs
				 * to be posted to the save action through
				 * Ajax
				 */
				var postData = $.extend(elem.find('input').serializeObject(), {
					items : menu.nestedSortable('toHierarchy', { attribute: 'data-item' })
				}); 

				// AJAX call to save menu
				$.ajax({
					url      : saveUri + (menuId ? '/' + menuId : ''),
					type     : 'POST',
					// dataType : 'json',
					data     : postData,
					success  : function(data, textStatus, jqXHR) {
						if (data.length && data != 'null') {
							data = data.replace(/null/gi, '');
							alert(data);
						}
					},
					error    : function(jqXHR, textStatus, errorThrown) {
						alert(jqXHR.status + ' ' + errorThrown);
					}
				});
			});
		}
	}

	// The actual jquery plugin
	$.fn.platformMenu = function(settings) {
		PlatformMenu.init(this, settings);
	}

	$.fn.serializeObject = function()
	{
		var o = {};
		var a = this.serializeArray();
		$.each(a, function() {
			if (o[this.name] !== undefined) {
				if (!o[this.name].push) {
					o[this.name] = [o[this.name]];
				}
				o[this.name].push(this.value || '');
			} else {
				o[this.name] = this.value || '';
			}
		});
		return o;
	};

})(jQuery);