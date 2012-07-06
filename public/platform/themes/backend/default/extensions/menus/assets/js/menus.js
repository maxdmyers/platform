(function() {

	/**
	 * MenuSortable object.
	 *
	 * @todo Add more validation support for
	 *       new items...
	 */
	var MenuSortable = {

		// Settings for this instance
		settings: {

			// New item selectors
			newItemContainerSelector: '.platform-new-item',
			newItemFieldContainerSelector: '.control-group',

			// Slug input selector
			slugInputSelector: '.item-slug',

			// Root menu item slug
			rootSlug: null,

			// What should be appended
			// to the root slug when namespacing
			// child items? Should match default
			// slug separator for your application
			rootSlugAppend: '-',

			// Root selector
			rootSlugSelector: '#menu-slug',

			// New item selectors
			newItemNameSelector: '#new-item-name',
			newItemSlugSelector: '#new-item-slug',

			// Nesty sortable settings
			nestySortable: {

				// Default nesty sortable settings for this menu
				sortableSelector : '.platform-menu',
				ajax             : false,
				invalidFieldCallback : function(field, value) {
					$(field.newSelector).closest('.control-group').addClass('error');
				}
			}
		},

		/**
		 * Used to initialise a new instance of
		 * nestySortable
		 */
		init: function(elem, settings) {
			var self  = this;
			self.elem = elem;

			$.extend(true, self.settings, settings);

			// Check for root slug
			if ( ! self.settings.rootSlug) {
				// $.error('A root menu slug is required by $.menuSortable');
			}

			// Check for nesty sortable
			if ( ! $().nestySortable) {
				$.error('$.menuSortable requires $.nestySortable');
			}

			// Check for nesty sortable settings
			if ( ! self.settings.nestySortable) {
				$.error('nestySortable configuration is required.');
			}

			// Setup Nesty sortable
			elem.nestySortable(self.settings.nestySortable);

			self.validateNewItems()
			    .validateSlugs()
			    .helpNewName();
		},

		validateNewItems: function() {
			var self = this;

			// Reverse the error on validation
			$(self.settings.newItemContainerSelector).find('input, textarea, select').on('focus keyup change', function(e) {

				if ($(this).is(':valid')) {
					$(this).closest(self.settings.newItemFieldContainerSelector).removeClass('error');
				}
			});

			return this;
		},

		/**
		 * Validates the slugs.
		 *
		 * @todo See if I can make this
		 *       faster...
		 */
		validateSlugs: function() {
			var self = this;

			// Slugify slugs
			$('body').on('blur', self.elem.selector+' '+self.settings.slugInputSelector+', '+self.settings.rootSlugSelector, function() {

				$(this).val($(this).slugify())
				       .trigger('change');
			});

			// New slug
			$(self.settings.rootSlugSelector).on('focus keyup change', function() {

				// Get the old slug
				var oldRootSlug = self.settings.rootSlug,
				       oldStart = oldRootSlug+self.settings.rootSlugAppend;

				// If there is a value
				if ($(this).val()) {

					// Change the new root slug
					self.settings.rootSlug = $(this).val();
					var newStart           = $(this).val()+self.settings.rootSlugAppend;

					// Change all existing items
					$.each(self.elem.find(self.settings.slugInputSelector), function() {

						// No slug at all, empty...
						if ( ! $(this).val()) {
							$(this).val(newStart);
						}

						// If the input had the old namespaced slug
						else if ($(this).val().indexOf(oldStart) === 0) {

							$(this).val($(this).val().replace(oldStart, newStart));
						}
					});
				}
			});

			// Namespace existing slugs
			$('body').on('focus keyup change', self.elem.selector+' '+self.settings.slugInputSelector, function(e) {

				if ($(this).val().indexOf(self.settings.rootSlug+self.settings.rootSlugAppend) !== 0) {
					$(this).val(self.settings.rootSlug+self.settings.rootSlugAppend+$(this).val());
				}

				// // Remove old value from array
				// var index = $.inArray($(this).data('old-value'), self.settings.slugs);
				// if (index > -1) {
				// 	self.settings.slugs.splice(index, 1);
				// }

				// // Set the old value for comparison next time
				// $(this).data('old-value', $(this).val());
			});

			// Trigger a change on the root item which
			// populates our cached root slug
			$(self.settings.rootSlugSelector).trigger('change');

			return this;
		},

		helpNewName: function() {
			var self = this;

			// Autofill the slug based on the name
			$(self.settings.newItemNameSelector).on('focus keyup change', function() {
				$(self.settings.newItemSlugSelector).val(self.settings.rootSlug+self.settings.rootSlugAppend+$(this).slugify());
			});

			return this;
		}
	}

	// The actual jquery plugin
	$.fn.menuSortable = function(settings) {
		MenuSortable.init(this, settings);
	}

})(jQuery);


// $(document).ready(function() {

// 	/*
// 	|-------------------------------------
// 	| New menu items
// 	|-------------------------------------
// 	|
// 	| Helpers for when adding new menu
// 	| items.
// 	*/
// 	$('body').on('hover', '.platform-new-item .control-group.error', function() {
// 		$(this).removeClass('error');
// 	})

// 	$('#new-item-name').on('focus keyup change', function(e) {
// 		$('#new-item-slug').val($(this).slugify());
// 	});

// 	$('#new-item-uri').on('focus keyup change', function(e) {

// 		// Full URL, disable the chekcbox
// 		if (isFullUrl($(this).val())) {
// 			$('#new-item-secure').attr('disabled', 'disabled');
// 			$('#new-item-secure')[isSecureUrl($(this).val()) ? 'attr' : 'removeAttr']('checked', 'checked');
// 		}

// 		// Relative, give option
// 		else {

// 			$('#new-item-secure').removeAttr('disabled');
// 		}
// 	});

// 	/*
// 	|-------------------------------------
// 	| Menu itself
// 	|-------------------------------------
// 	|
// 	| Helpers for when editing the menu
// 	| options
// 	*/
// 	$('#menu-name').on('focus keyup change', function(e) {
// 		$('#menu-slug').val($(this).slugify());
// 	});

// 	/*
// 	|-------------------------------------
// 	| Secure menu items
// 	|-------------------------------------
// 	|
// 	| Allows for easy setup of the secure
// 	| menu items.
// 	*/
// 	$('body').on('focus keyup change', '.menu-item-uri', function(e) {

// 		var $secure = $(this).closest('.item').find('.menu-item-secure');

// 		// Full URL
// 		if (isFullUrl($(this).val())) {
// 			$secure.attr('disabled', 'disabled');
// 			$secure[isSecureUrl($(this).val()) ? 'attr' : 'removeAttr']('checked', 'checked');
// 		}

// 		// Relative URI
// 		else {
// 			$secure.removeAttr('disabled');
// 		}
// 	});

// 	/**
// 	 * Tests a URL to see if it's a full
// 	 * url
// 	 *
// 	 * @param   string  uri
// 	 * @return  bool
// 	 */
// 	function isFullUrl(uri) {
// 		return /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/.test(uri);
// 	}

// 	/**
// 	 * Tests a URL to see if it's secure
// 	 *
// 	 * @param   string  uri
// 	 * @return  bool
// 	 */
// 	function isSecureUrl(uri) {
// 		return /https:\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/.test(uri);
// 	}
// });