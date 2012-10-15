<?php if (count($items)):?>
	
	<?php foreach($items as $comment):?>
		<tr>
			<td><?= $comment->content;?></td>
			<td><?= $comment->login;?></td>
			<td><?= $comment->insert_date; ?></td>
			<td>
				<?= Html::anchor('admin/comments/del/'.$comment->id, '<i class="icon-trash icon-white"></i> '.__('buttonDel'), array('class'=>'btn btn-small btn-inverse delete'));?>
			</td>
		</tr>
	<?php endforeach;?>
        <?php else: ?>
		<tr>
			<td colspan="5"><?= __('labelNullComments'); ?>
			</td>
		</tr>
<?php endif;?>