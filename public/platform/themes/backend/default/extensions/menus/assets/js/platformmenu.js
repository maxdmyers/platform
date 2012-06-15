/**
 * Function : dump()
 * Arguments: The data - array,hash(associative array),object
 *    The level - OPTIONAL
 * Returns  : The textual representation of the array.
 * This function was inspired by the print_r function of PHP.
 * This will accept some data as the argument and return a
 * text that will be a more readable version of the
 * array/hash/object that is given.
 * Docs: http://www.openjs.com/scripts/others/dump_function_php_print_r.php
 */
function dump(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;
	
	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";
	
	if(typeof(arr) == 'object') { //Array/Hashes/Objects 
		for(var item in arr) {
			var value = arr[item];
			
			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
}



(function() {
	
	// NestySortable object.
	/**
	 * @todo Add more validation support for
	 *       new items...
	 */
	var NestySortable = {

		// Settings for this instance
		settings: {

			// The selector for the sortable list,
			// used to cache the sortable list property
			sortableSelector: null,

			/**
			 * An array of fields for the Nesty sortable.
			 *
			 * <code>
			 *		{ name : 'my_field', newSelector : '.new-item-my-field', required : false }
			 * </code>
			 *
			 * @var array
			 */
			fields : [],

			// Selectors relating to items, but aren't
			// located inside each item in the DOM
			itemAddButtonSelector        : '.items-add-new',
			itemToggleAllDetailsSelector : '.items-toggle-all',

			// JSON encoded string for new item template
			itemTemplate: '',

			// The ID of the last item added. Used so we fill
			// new templates with an ID that won't clash with existing
			// items.
			lastItemId: 0,

			// Selectors for DOM elements for each active
			// item.
			itemSelector              : '.item',
			itemHandleSelector        : '.item-header',
			itemToggleDetailsSelector : '.item-toggle-details',
			itemDetailsSelector       : '.item-details',
			itemRemoveSelector        : '.item-remove',

			// Invalid field callback - must return true for valid
			// field or false for invalid field.
			invalidFieldCallback : function(field, value) {},

			// Misc
			maxLevels : 0,
			tabSize   : 20
		},

		// The form object we call $.nestySortable on
		elem: null,

		// The sortable list DOM object, cached
		// for speed
		_sortable: null,

		// The selector for an item add button
		_itemAddButton: null,

		/**
		 * Used to initialise a new instance of
		 * nestySortable
		 */
		init: function(elem, settings) {
			var self  = this;
			self.elem = elem;

			$.extend(self.settings, settings);

			// Initialise NestedSortable
			self.sortable().nestedSortable({
				disableNesting       : 'no-nest',
				forcePlaceholderSize : true,
				handle               : self.settings.itemHandleSelector,
				helper               :'clone',
				items                : 'li',
				maxLevels            : self.settings.maxLevels,
				opacity              : 0.6,
				placeholder          : 'placeholder',
				revert               : 250,
				tabSize              : self.settings.tabSize,
				tolerance            : 'pointer',
				toleranceElement     : '> div'
			});

			self.observerAddingItems();
		},

		/**
		 * Used to retrieve the sortable DOM object.
		 */
		sortable: function() {
			var self = this;

			if ( ! self._sortable) {
				self._sortable = self.elem.find(self.settings.sortableSelector);
			}

			return self._sortable;
		},

		/**
		 * Used to retrieve the add button DOM object.
		 */
		itemAddButton: function() {
			var self = this;

			if ( ! self._itemAddButton) {
				self._itemAddButton = self.elem.find(self.settings.itemAddButtonSelector);
			}

			return self._itemAddButton;
		},

		/**
		 * Observe adding items.
		 */
		observerAddingItems: function() {
			var self = this;

			// When user clicks on the add item button
			self.itemAddButton().on('click', function(e) {
				e.preventDefault();

				// Get the item template
				var itemTemplate = self.settings.itemTemplate;

				// Flag for valid itemTemplate
				var valid = true;

				// Loop through the defined fields, and replace
				// the template variables with the value of each
				// field's selector.
				for (i in self.settings.fields) {
					var field = self.settings.fields[i];

					var value = $(field.newSelector).val();

					if (typeof field.required !== 'undefined' && field.required === true && (typeof value === 'undedfined' || ! value)) {

						result = self.settings.invalidFieldCallback(field, value);

						if (typeof result !== 'undefiend' && valid === true) {
							valid = Boolean(result);
						}
					}

					// Replace the name with the actual value
					var regex    = new RegExp('\{\{'+field.name+'\}\}', 'gi');
					itemTemplate = itemTemplate.replace(regex, value);
				}

				if (valid !== true) {
					return false;
				}

				// Lastly, add the ID
				var itemId               = self.settings.lastItemId + 1;
				itemTemplate             = itemTemplate.replace(/\{\{id\}\}/gi, itemId);
				self.settings.lastItemId = itemId;

				// Append to DOM
				self.sortable().append(itemTemplate);

				// Wipe fields
				for (i in self.settings.fields) {
					$(self.settings.fields[i].newSelector).val('');
				}
			});

			return this;
		}
	}

	// The actual jquery plugin
	$.fn.nestySortable = function(settings) {
		NestySortable.init(this, settings);
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