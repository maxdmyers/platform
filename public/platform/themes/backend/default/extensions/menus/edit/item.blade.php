<li data-item="item_{{ $item['id'] }}">

	<div class="item">

		<header class="item-header">
			{{ $item['name'] }} <span class="item-sort"><i class="icon-resize-vertical"></i></span>
		</header>

		<section>

			{{ Form::hidden('inputs['.$item['id'].'][is_new]', 0)}}

			{{ Form::label('menu-items-'.$item['id'].'-name', 'Name') }}
			{{ Form::text('inputs['.$item['id'].'][name]', $item['name'], array('id' => 'menu-items-'.$item['id'].'-name', 'placeholder' => 'Name')) }}

			{{ Form::label('menu-items-'.$item['id'].'-slug', 'Slug') }}
			{{ Form::text('inputs['.$item['id'].'][slug]', $item['slug'], array('id' => 'menu-items-'.$item['id'].'-slug', 'placeholder' => 'Slug')) }}

			{{ Form::label('menu-items-'.$item['id'].'-uri', 'Uri') }}
			{{ Form::text('inputs['.$item['id'].'][uri]', $item['uri'], array('id' => 'menu-items-'.$item['id'].'-uri', 'placeholder' => 'Uri')) }}

		</section>

	</div>

	@if ($item['children'])



	@endif

</li>