if (window.attachEvent) {
	function fixBase() {
		var base= document.getElementById('Inside');
		base.style.height = null;
		base.style.height = base.parentNode.offsetHeight+'px';
	}
	window.attachEvent('onload', fixBase);
	window.attachEvent('onresize', fixBase);
}
