<?php if (count($items)) :?>
	
	<?php foreach($items as $article):?>
		<tr>
			<td><?= $article->title;?></td>
			<td><?= $article->author;?></td>
			<td>
			<?php if ($article->is_published): ?>
				<?= $article->publication_date;?>
			<?php else: ?>
				<?= __('labelNotPublished'); ?>
			<?php endif;?>
			</td>
			<td>
				<?php if ($article->comments):?>
					<span class="badge"><?= $article->comments; ?></span>
				<?php else: ?>
					<span class="badge"><?= __('labelLack'); ?></span>
				<?php endif; ?>
				</td>
			<td><?= $article->modification_date; ?></td>
			<td>
				<div class="btn-group pull-left">
					<button class="btn btn-danger btn-small"><?= __('buttonManage'); ?></button>
					<button class="btn dropdown-toggle btn-small btn-danger" data-toggle="dropdown">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						
						<li><?= Html::anchor('admin/articles/edit/'.$article->id, '<i class="icon-edit"></i> '.__('buttonEdit'));?></li>
						<li><?= Html::anchor('admin/comments/'.$article->id.'/'.Model_Comment::TYPE_ARTICLE, '<i class="icon-share"></i> '.__('buttonComments'));?></li>
					</ul>
				</div> 

				
				<?= Html::anchor('admin/articles/del/'.$article->id, '<i class="icon-trash icon-white"></i> '.__('buttonDel'), array('class'=>'btn btn-small btn-inverse delete pull-left', 'style'=>'margin-left: 10px;'));?>
			</td>
		</tr>
	<?php endforeach;?>
        <?php else: ?>
		<tr>
			<td colspan="5">
				<?= __('labelNullNews'); ?>
			</td>
		</tr>
<?php endif;?>