(function() {

	// CartMenu plugin
	var CartaMenu = {

		// Settings
		settings : {

			/**
			 * Selectors for a new 
			 * menu item
			 */
			newItemSelectors : {
				name : '.new-item-name',
				uri  : '.new-item-uri',
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
				$uri  = elem.find(selectors.uri);

				self.addMenuItem($name.val(), $uri.val());
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
		 * @return CartaMenu
		 */
		addMenuItem: function(name, uri) {

			if (name.length == 0 || uri.length == 0) {
				return alert('Fill out all fields.');
			}

			var self         = this;
			var elem         = self.elem;
			var menu         = self.menu;
			var id           = self.settings.lastItemId  + 1;
			var itemTemplate = self.settings.itemTemplate;

			// Update our template with real vars
			itemTemplate = itemTemplate.replace(/\{\{name\}\}/gi, name)
			                           .replace(/\{\{id\}\}/gi, id)
			                           .replace(/\{\{uri\}\}/gi, uri)

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
	$.fn.cartaMenu = function(settings) {
		CartaMenu.init(this, settings);
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

// $(document).ready(function(){

// 	$('ol.sortable').nestedSortable({
// 		disableNesting: 'no-nest',
// 		forcePlaceholderSize: true,
// 		handle: 'div',
// 		helper:	'clone',
// 		items: 'li',
// 		maxLevels: 3,
// 		opacity: .6,
// 		placeholder: 'placeholder',
// 		revert: 250,
// 		tabSize: 25,
// 		tolerance: 'pointer',
// 		toleranceElement: '> div'
// 	});

// 	$('#serialize').click(function(){
// 		serialized = $('ol.sortable').nestedSortable('serialize');
// 		$('#serializeOutput').text(serialized+'\n\n');
// 	})

// 	$('#toHierarchy').click(function(e){
// 		hiered = $('ol.sortable').nestedSortable('toHierarchy', {startDepthCount: 0});
// 		hiered = dump(hiered);
// 		(typeof($('#toHierarchyOutput')[0].textContent) != 'undefined') ?
// 		$('#toHierarchyOutput')[0].textContent = hiered : $('#toHierarchyOutput')[0].innerText = hiered;
// 	})

// 	$('#toArray').click(function(e){
// 		arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
// 		arraied = dump(arraied);
// 		(typeof($('#toArrayOutput')[0].textContent) != 'undefined') ?
// 		$('#toArrayOutput')[0].textContent = arraied : $('#toArrayOutput')[0].innerText = arraied;
// 	})

// });