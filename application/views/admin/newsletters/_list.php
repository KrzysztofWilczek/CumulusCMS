<?php if (!count($items)):?>
		<tr><td colspan="5"><?= __('labelNullNewsletters'); ?></td></tr>	
	<?php else:?>
	<?php foreach($items as $newsletter):?>
		<tr>
			<td><?= $newsletter->title;?></td>
			<td><?= Model_Newsletter::getStatusName($newsletter); ?></td>
                        <td><?php if ($newsletter->subscribers_count > 0): ?>
                            <?php if ($newsletter->is_sent): ?>
                                <span class="badge"><?= $newsletter->subscribers_count; ?></span>
                            <?php else: ?>
                                <span class="badge badge-inverse"><?= $newsletter->subscribers_count; ?></span>
                            <?php endif; ?>
                            <?php else: ?>
				<span class="badge"><?= __('labelLack'); ?></span>
                            
                            <?php endif; ?>
                             
			</td>
			<td><?= $newsletter->send_date; ?></td>
			<td><?= $newsletter->modification_date; ?></td>
			<td>
				<div class="btn-group pull-left">
					<button class="btn btn-danger btn-small"><?= __('buttonManage'); ?></button>
					<button class="btn dropdown-toggle btn-small btn-danger" data-toggle="dropdown">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<?php $status = Model_Newsletter::getStatus($newsletter); ?>
						<li><?= Html::anchor('admin/newsletters/edit/'.$newsletter->id, '<i class="icon-edit"></i> '.__('buttonEdit'));?></li>
						<?php if ($status == Model_Newsletter::STATUS_DRAFT): ?>
						<li><?= Html::anchor('admin/newsletters/test/'.$newsletter->id, '<i class="icon-download-alt"></i> '.__('buttonTest'));?></li>
						<li><?= Html::anchor('admin/newsletters/send/'.$newsletter->id, '<i class="icon-envelope"></i> '.__('buttonSend'));?></li>
						<?php endif; ?>
						<li><?= Html::anchor('admin/newsletters/copy/'.$newsletter->id, '<i class="icon-download-alt"></i> '.__('buttonCopy'));?></li>
						
					</ul>
				</div> 

				<?= Html::anchor('admin/newsletters/del/'.$newsletter->id, '<i class="icon-trash icon-white"></i> '.__('buttonDel'), array('class'=>'btn btn-small btn-inverse delete pull-left', 'style'=>'margin-left: 10px;'));?>
			</td>
		</tr>
	<?php endforeach;?>
	<?php endif;?>