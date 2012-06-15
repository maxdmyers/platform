@layout('templates.template')

@section('title')
	menus.title
@endsection

@section('links')
	{{ Theme::asset('menus::css/menus.less') }}
@endsection

@section('body_scripts')
	{{ Theme::asset('js/bootstrap/bootstrap-tab.js') }}
@endsection

@section('content')

<section id="menus-edit">

	<header class="head row">
		<div class="span4">
			<h1>Edit Menu</h1>
			<p>Blah blah blah</p>
		</div>
	</header>

	<hr>

	<div class="tabbable">
		<ul class="nav nav-tabs">
			<li class="{{ ($menu_id) ? 'active' : null }}"><a href="#menus-edit-items" data-toggle="tab">Items</a></li>
			<li class="{{ ( ! $menu_id) ? 'active' : null }}"><a href="#menus-edit-menu-options" data-toggle="tab">Menu Options</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane {{ ($menu_id) ? 'active' : null }}" id="menus-edit-items">
				
				<ol class="platform-menu" id="platform-menu">
					@if ($menu['children'])
						@foreach ($menu['children'] as $child)
							@render('menus::edit.item', array('item' => $child))
						@endforeach
					@endif
				</ol>

			</div>
			<div class="tab-pane {{ ( ! $menu_id) ? 'active' : null }}" id="menus-edit-menu-options">
				
				{{ Form::label('menu-name', 'Name') }}
				{{ Form::text('name', isset($menu['name']) ? $menu['name'] : null, array('id' => 'menu-name', 'placeholder' => 'Name')) }}

				{{ Form::label('menu-slug', 'Slug') }}
				{{ Form::text('slug', isset($menu['slug']) ? $menu['slug'] : null, array('id' => 'menu-slug', 'placeholder' => 'Slug')) }}

			</div>
		</div>
	</div>

	<div class="form-actions">

		<button type="submit" class="btn btn-primary btn-save-menu">
			{{ $menu_id ? 'Save' : 'Create' }} Menu
		</button>

		{{ HTML::link(ADMIN.'/menus', $menu_id ? 'Back' : 'Cancel', array('class' => 'btn')) }}

	</div>

</section>

@endsection