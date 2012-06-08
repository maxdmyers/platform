@layout('templates.template')



@section('title')
	menus.title
@endsection


@section('links')
	{{ Theme::asset('menus::css/menus.css') }}
@endsection




@section('content')

<div class="page-header">
	<h1>
		Edit Menu
	</h1>
</div>

<ol>
	<li>JS to remove menu item is broken, but is developed. Just needs fixing</li>
</ol>

<div class="row carta-menu">
	<div class="span3">
		
		<h2 id="add">Add Menu Item</h2>

		<p>Please type a name and Uri for the new menu item and click <strong>add to menu</strong> below.</p>

		<input class="new-item-name" placeholder="Name">
		<br>
		<input class="new-item-slug" placeholder="Slug">
		<br>
		<input class="new-item-uri" placeholder="Uri">
		<br>

		<button type="button" class="btn new-item-add">
			Add to Menu
		</button>

		<hr>

		<h2>Menu Properties</h2>

		{{ Form::label('form_name', 'Menu Name') }}
		{{ Form::text('name', isset($menu['name']) ? $menu['name'] : null, array('id' => 'form_name')) }}

		{{ Form::label('form_slug', 'Menu Slug') }}
		{{ Form::text('slug', isset($menu['slug']) ? $menu['slug'] : null, array('id' => 'form_slug')) }}

		<div class="form-actions">
			<button type="button" class="btn btn-primary save-menu">
				Save Menu
			</button>
			<a href="{{ URL::to(ADMIN.'/menus') }}" class="btn">
				{{ $menu_id ? 'Back' : 'Cancel' }}
			</a>
		</div>

	</div>
	<div class="span7">
		<h2>Your Menu</h2>

		<ol class="actual-menu">
			{{ $menus_view }}
		</ol>
	</div>
</div>

@endsection



@section('body_scripts')

{{ Theme::asset('js/jquery/ui-1.8.18.min.js') }}
{{ Theme::asset('menus::js/jquery/nestedsortable-1.3.4.js') }}
{{ Theme::asset('menus::js/cartamenu.js') }}
{{ Theme::asset('menus::js/menus.js') }}

<script>
$(document).ready(function() {

	/**
	 * @todo, use window.history.replaceState() when a new
	 *        item is saved, so that the /create url becomes
	 *        /edit/:menu. Probably needs to be done here so we
	 *        know our URLs.
	 */

	// Carta menu
	$('.carta-menu').cartaMenu({
		menuId       : {{ $menu_id }},
		saveUri      : '{{ URL::to(ADMIN.'/menus/edit') }}',
		itemTemplate : {{ $item_template }},
		lastItemId   : {{ $last_item_id }}
	});
});
</script>

@endsection
