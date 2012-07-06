<li data-item="item_{{id}}">

	<div class="item">

		<header class="item-header">
			<span class="item-sort"><i class="icon-move"></i></span> {{raw.name}} <span class="item-toggle-details"><i class="icon-edit"></i></span>
		</header>

		<section class="clearfix item-details">

			<div class="well">
				<?php echo Form::hidden('item_fields[{{id}}][is_new]', 1); ?>

				<div class="control-group">
					<?php echo Form::label('menu-items-{{id}}-name', Lang::line('menus::menus.general.name')); ?>
					<?php echo Form::text('item_fields[{{id}}][name]', null, array('id' => 'menu-items-{{id}}-name', 'placeholder' => Lang::line('menus::menus.general.name'), '{{field.name}}', 'required')); ?>
				</div>

				<div class="control-group">
					<?php echo Form::label('menu-items-{{id}}-slug', Lang::line('menus::menus.general.slug')); ?>
					<?php echo Form::text('item_fields[{{id}}][slug]', null, array('id' => 'menu-items-{{id}}-slug', 'placeholder' => Lang::line('menus::menus.general.slug'), 'class' => 'item-slug', '{{field.slug}}', 'required')); ?>
				</div>

				<div class="control-group">
					<?php echo Form::label('menu-items-{{id}}-uri', Lang::line('menus::menus.general.uri')); ?>
					<?php echo Form::text('item_fields[{{id}}][uri]', null, array('id' => 'menu-items-{{id}}-uri', 'placeholder' => Lang::line('menus::menus.general.uri'), 'class' => 'item-uri', '{{field.uri}}', 'required')); ?>
				</div>

				<div class="control-group">
					<label class="checkbox">
						<input type="checkbox" name="item_fields[{{id}}][secure]" value="1" id="menu-items-{{id}}-secure" class="item-secure" {{field.secure}} required>
						<?php echo Lang::line('menus::menus.general.secure'); ?>
					</label>
				</div>

				<div class="control-group">
					<?php echo Form::label('menu-items-{{id}}-status', Lang::line('menus::menus.general.status')); ?>
					<?php echo Form::select('item_fields[{{id}}][status]', array(1 => Lang::line('menus::menus.general.yes'), 0 => Lang::line('menus::menus.general.no')), 1, array('id' => 'menu-items-{{id}}-status')); ?>
				</div>
			</div>

			<button class="pull-right btn btn-danger btn-mini item-remove">
				Remove Item
			</button>

		</section>

	</div>

</li>