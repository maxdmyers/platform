<li data-item="item_{{id}}">
	<div>
		<header>{{name}}<span class="toggle">&uarr;&darr;</span></header>
		<section>
			<input type="hidden" name="inputs[{{id}}][is_new]" value="1">
			<label>Name</label>
			<input type="text" name="inputs[{{id}}][name]" value="{{name}}" placeholder="Item name">
			<br>
			<br>
			<label>Slug</label>
			<input type="text" name="inputs[{{id}}][slug]" value="{{slug}}" placeholder="Slug">
			<br>
			<br>
			<label>Uri</label>
			<input type="text" name="inputs[{{id}}][uri]" value="{{uri}}" placeholder="Item Uri">
			<br>
			<a href="#" class="btn btn-small btn-danger remove">Remove Item</a>
		</section>
	</div>
</li>