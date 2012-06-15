<li data-item="item_{{id}}">

	<div class="item">

		<header class="item-header">
			<span class="item-sort"><i class="icon-move"></i></span> {{name}} <span class="item-toggle-details"><i class="icon-edit"></i></span>
		</header>

		<section class="clearfix item-details">

			<div class="form-inline well">
				<input type="hidden" name="item_fields[{{id}}][is_new]" value="1">

				<label for="menu-items-{{id}}-name">Name</label>
				<input type="text" name="item_fields[{{id}}][name]" value="{{name}}" id="menu-items-{{id}}-name" placeholder="Name">

				<label for="menu-items-{{id}}-slug">Slug</label>
				<input type="text" name="item_fields[{{id}}][slug]" value="{{slug}}" id="menu-items-{{id}}-slug" placeholder="Slug">

				<label for="menu-items-{{id}}-uri">Uri</label>
				<input type="text" name="item_fields[{{id}}][uri]" value="{{uri}}" id="menu-items-{{id}}-uri" placeholder="Uri">
			</div>

			<button class="pull-right btn btn-danger btn-mini item-remove">
				Remove Item
			</button>

		</section>

	</div>

</li>