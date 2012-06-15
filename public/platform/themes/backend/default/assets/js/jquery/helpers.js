// Tiny plugin to serialise an object
$.fn.serializeObject = function() {

	var o = {};
	var a = this.serializeArray();
	$.each(a, function() {
		if (o[this.name] !== undefined) {
			if ( ! o[this.name].push) {
				o[this.name] = [o[this.name]];
			}
			o[this.name].push(this.value || '');
		} else {
			o[this.name] = this.value || '';
		}
	});
	return o;
};

// Function taken from http://dense13.com/blog/2009/05/03/converting-string-to-slug-javascript/
// Some extra special characters added.
$.fn.slugify = function(separator) {

	if (typeof separator === 'undefined') {
		separator = '-';
	}

	// Get value attribute
	var str = this.val();

	str = str.replace(/^\s+|\s+$/g, ''); // trim
	str = str.toLowerCase();
	
	// remove accents, swap ñ for n, etc
	var from = "ĺěščřžýťňďàáäâèéëêìíïîòóöôùůúüûñç·/_,:;";
	var to   = "lescrzytndaaaaeeeeiiiioooouuuuunc------";
	for (var i=0, l=from.length ; i<l ; i++) {
		str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
	}

	str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
		.replace(/\s+/g, separator) // collapse whitespace and replace by _
		.replace(/-+/g, separator); // collapse dashes

	return str;
}