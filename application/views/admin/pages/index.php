<h1><?= __('menuPagesList'); ?></h1>
<ul class="breadcrumb">
	<li><?= Html::anchor('admin', __('menuPanel')); ?> <span class="divider">/</span></li>
	<li class="active"><?= __('menuPagesList'); ?></li>
</ul>
<?= Html::anchor('admin/pages/add', '<i class="icon-plus-sign icon-white"></i> '.__('menuPagesAdd'), array('class' => 'pull-right btn btn-danger')); ?>
<?= View::factory('helpers/search');?>
<blockquote><?= __('quotePages'); ?></blockquote>

<table class="table table-striped  table-bordered">
	<thead>
	<tr>
		<th><?=$pagination->sortHeader(__('thTitle'), 'title');?></th>
		<th><?=$pagination->sortHeader(__('thUrl'), 'url');?></th>
		<th><?=$pagination->sortHeader(__('thLastModification'), 'modification_date');?></th>
		<th><?=$pagination->sortHeader(__('thAttention'), 'is_removable');?></th>
		<th></th>
	</tr>
	</thead>
	<tbody id="reloaded">
		<?= View::factory('admin/pages/_list')->set('items', $pagination->currentItems);?>
	</tbody>
	
</table>
<?= View::factory('helpers/perpage');?>
<?= $pagination; ?>

<?= View::factory('admin/prompt'); ?>