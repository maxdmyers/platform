@layout('templates/template')



@section('title')
	menus.title
@endsection


@section('links')
	{{ Theme::asset('menus::css/menus.css') }}
@endsection




@section('content')

<div class="carta-menu">
	<div class="editor">
		<h2 id="add">Add Menu Item</h2>

		<p>Please type a name and Uri for the new menu item and click <strong>add to menu</strong> below.</p>

		<input class="input-small new-item-name" placeholder="Name">
		<input class="input-small new-item-uri" placeholder="Uri">
		<br>

		<button type="button" class="btn primary new-item-add">
			Add to Menu
		</button>

		<button type="button" class="save-menu">
			Save Menu
		</button>
	</div>
	<div class="menu-area">
		<h2>Your Menu</h2>

		<ol class="actual-menu">
			{{ $menus_view }}
		</ol>
	</div>
</div>

@endsection



@section('body_scripts')

<script src="{{ Theme::asset('js/jquery/ui-1.8.18.min.js') }}"></script>
<script src="{{ Theme::asset('menus::js/jquery/nestedsortable-1.3.4.js') }}"></script>
<script src="{{ Theme::asset('menus::js/cartamenu.js') }}"></script>

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
		menuId       : <?=$menu_id?>,
		saveUri      : '{{ URL::to('api/menus/save') }}',
		itemTemplate : {{ $item_template }},
		lastItemId   : 4
	});
});
</script>
@endsection
