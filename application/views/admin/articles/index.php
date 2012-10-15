<h1><?= __('menuNews'); ?></h1>
<ul class="breadcrumb">
	<li><?= Html::anchor('admin', __('menuPanel')); ?> <span class="divider">/</span></li>
	<li class="active"><?= __('menuNewsList'); ?></li>
</ul>
<?= Html::anchor('admin/articles/add', '<i class="icon-plus-sign icon-white"></i> '.__('menuNewsAdd'), array('class' => 'pull-right btn btn-danger')); ?>
<?= View::factory('helpers/search');?>
<blockquote><?= __('quoteNews'); ?></blockquote>
<table class="table table-striped  table-bordered">
	<thead>
	<tr>
		<th><?=$pagination->sortHeader(__('thTitle'), 'title');?></th>
		<th><?=$pagination->sortHeader(__('thAuthor'), 'author');?></th>
		<th><?=$pagination->sortHeader(__('thPublished'), 'is_published');?></th>
		<th><?=$pagination->sortHeader(__('thComments'), 'comments');?></th>
		<th><?=$pagination->sortHeader(__('thLastModification'), 'modification_date');?></th>
		<th></th>
	</tr>
	</thead>
	<tbody id="reloaded">
		<?= View::factory('admin/articles/_list')->set('items', $pagination->currentItems);?>
	</tbody>

	
</table>
<?= View::factory('helpers/perpage');?>
<?= $pagination; ?>

<?= View::factory('admin/prompt'); ?>
