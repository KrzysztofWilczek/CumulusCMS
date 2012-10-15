<h1><?= __('menuComments'); ?></h1>
<ul class="breadcrumb">
	<li><?= Html::anchor('admin', __('menuPanel')); ?> <span class="divider">/</span></li>
	<li class="active"><?= __('menuCommentsList');?></li>
</ul>
<blockquote><?= __('quoteComments'); ?></blockquote>
<table class="table table-striped  table-bordered">
	<thead>
	<tr>
		<th><?=$pagination->sortHeader(__('thContent'), 'content');?></th>
		<th><?=$pagination->sortHeader(__('thAuthor'), 'user_id');?></th>
		<th><?=$pagination->sortHeader(__('thAdded'), 'insert_date');?></th>
		<th></th>
	</tr>
	</thead>
	<tbody id="reloaded">
		<?= View::factory('admin/comments/_list')->set('items', $pagination->currentItems);?>
	</tbody>
	
</table>
<?= View::factory('helpers/perpage');?>
<?= $pagination; ?>

<?= View::factory('admin/prompt'); ?>
