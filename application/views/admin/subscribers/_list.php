<?php if (!count($items)):?>
		<tr><td colspan="4"><?= __('labelNullSubscribers'); ?></td></tr>	
	<?php else:?>
	<?php foreach($items as $subscriber):?>
		<tr>
			<td><?= $subscriber->email;?></td>
                        <td><?= $subscriber->registration_date;?></td>
                        <td>
                            <?php if ($subscriber->is_confirmed): ?>
                                <span class="label"><?= __('labelVerified'); ?></span>
                            <?php else: ?>
                                <span class="label label-important"><?= __('labelNotVerified'); ?></span>
                            <?php endif; ?>
                        </td>
			<td>
				<?= Html::anchor('admin/subscribers/del/'.$subscriber->id, '<i class="icon-trash icon-white"></i> '.__('buttonDel'), array('class'=>'btn btn-small btn-inverse delete'));?>
			</td>
		</tr>
	<?php endforeach;?>
	<?php endif;?>