// Just incase the files get loaded out of order
if (platform == undefined)
{
	var platform = { };
}

// start helpers
(function($) {
	// define Helpers object
	platform.url = {

		urls : {
			base: null,
			admin: null,
		},

		init: function() {
			this.urls.base  = $('meta[name=base_url]').attr('content');
			this.urls.admin = $('meta[name=admin_url]').attr('content');
		},

		base: function(path) {
			if (path === undefined) {
				path = ''
			}

			return this.urls.base + path;
		},

		admin: function(path) {
			if (path === undefined) {
				path = ''
			}

			return this.urls.admin + path;
		}

	};

	platform.url.init();

})(jQuery);
