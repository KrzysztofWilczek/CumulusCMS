	<?php if (!count($items)):?>
		<tr><td colspan="4"><?= __('labelNullPages'); ?></td></tr>	
	<?php else:?>
	<?php foreach($items as $page):?>
		<tr>
			<td><?= $page->title;?></td>
			<td><?= $page->url; ?></td>
			<td><?= $page->modification_date;?></td>
			<td><?php if (!$page->is_removable):?><?= __('labelConstPage'); ?><?php endif;?></td>
			<td>
				<?= Html::anchor('admin/pages/edit/'.$page->id, '<i class="icon-edit icon-white"></i> '.__('buttonEdit'), array('class'=>'btn btn-small btn-danger'));?>
				<?php if ($page->is_removable): ?>
				<?= Html::anchor('admin/pages/del/'.$page->id, '<i class="icon-trash icon-white"></i> '.__('buttonDel'), array('class'=>'btn btn-small btn-inverse delete'));?>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach;?>
	<?php endif;?>