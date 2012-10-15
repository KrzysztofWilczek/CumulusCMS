<?php if (!count($items)):?>
		<tr><td colspan="4"><?= __('labelNullTemplates'); ?></td></tr>	
	<?php else:?>
	<?php $types = Model_Template::getTypes(); ?>
	<?php foreach($items as $template):?>
		<tr>
			<td><?= $template->name;?></td>
			<td><?= $template->code;?></td>
			<td><?= $types[$template->type]; ?></td>
			<td><?php if (!$template->is_removable): ?>
				<?= __('labelIrremovable'); ?>
				Nie usuwalny
				<?php endif; ?>
			</td>
			<td>
				<?= Html::anchor('admin/templates/edit/'.$template->id, '<i class="icon-edit icon-white"></i> '.__('buttonEdit'), array('class'=>'btn btn-small btn-danger'));?>
				<?php if ($template->is_removable): ?>
				<?= Html::anchor('admin/templates/del/'.$template->id, '<i class="icon-trash icon-white"></i> '.__('buttonDel'), array('class'=>'btn btn-small btn-inverse'));?>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach;?>
	<?php endif;?>