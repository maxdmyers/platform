<li data-item="item_{{ {{id}} }}">

	<div class="item">

		<header class="item-header">
			<span class="item-sort"><i class="icon-move"></i></span> {{ {{name}} }} <span class="item-toggle-details"><i class="icon-edit"></i></span>
		</header>

		<section class="clearfix item-details">

			<div class="form-inline well">
				{{ Form::hidden('item_fields[{{id}}][is_new]', 0)}}

				{{ Form::label('menu-items-{{id}}-name', 'Name') }}
				{{ Form::text('item_fields[{{id}}][name]', {{name}}, array('id' => 'menu-items-{{id}}-name', 'placeholder' => 'Name')) }}

				{{ Form::label('menu-items-{{id}}-slug', 'Slug') }}
				{{ Form::text('item_fields[{{id}}][slug]', {{slug}}, array('id' => 'menu-items-{{id}}-slug', 'placeholder' => 'Slug')) }}

				{{ Form::label('menu-items-{{id}}-uri', 'Uri') }}
				{{ Form::text('item_fields[{{id}}][uri]', {{uri}}, array('id' => 'menu-items-{{id}}-uri', 'placeholder' => 'Uri')) }}
			</div>

			<button class="pull-right btn btn-danger btn-mini item-remove">
				Remove Item
			</button>

		</section>

	</div>

</li>