<li data-item="item_{{ $menu['id'] }}">
	<div>
		<header>{{ $menu['name'] }}<span class="toggle">&uarr;&darr;</span></header>
		<section>
			<input type="hidden" name="inputs[{{ $menu['id'] }}][is_new]" value="0">
			<label>Name</label>
			<input type="text" {{ ! $menu['user_editable'] ? 'readonly' : null }} name="inputs[{{ $menu['id'] }}][name]" value="{{ $menu['name'] }}" placeholder="Item name">
			<br>
			<br>
			<label>Slug</label>
			<input type="text" {{ ! $menu['user_editable'] ? 'readonly' : null }} name="inputs[{{ $menu['id'] }}][slug]" value="{{ $menu['slug'] }}" placeholder="Slug">
			<br>
			<br>
			<label>Uri</label>
			<input type="text" {{ ! $menu['user_editable'] ? 'readonly' : null }} name="inputs[{{ $menu['id'] }}][uri]" value="{{ $menu['uri'] }}" placeholder="Item Uri">
			<br>
			@if ( ! $menu['user_editable'])
				This menu item isn't editable. However, you can still move it around...
			@else
				<a href="#" class="btn btn-small btn-danger remove">Remove Item</a>
			@endif
		</section>
	</div>
	@if ($children)
		<ol>
			@foreach ($children as $child)
				{{ $child }}
			@endforeach
		</ol>
	@endif
</li>