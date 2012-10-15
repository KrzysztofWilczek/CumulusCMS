<h1><?= __('menuTemplates'); ?></h1>
<ul class="breadcrumb">
	<li><?= Html::anchor('admin', __('menuPanel')); ?> <span class="divider">/</span></li>
	<li class="active"><?= __('menuTemplatesList'); ?></li>
</ul>
<blockquote><?= __('quoteTemplates'); ?></blockquote>
<table class="table table-striped  table-bordered">
	<thead>
	<tr>
		<th><?=$pagination->sortHeader(__('thTitle'), 'name');?></th>
		<th><?=$pagination->sortHeader(__('thCodeName'), 'code');?></th>
		<th><?=$pagination->sortHeader(__('thType'), 'type');?></th>
		<th><?= __('thAttention'); ?></th>
		<th></th>
	</tr>
	</thead>
	<tbody id="reloaded">
		<?= View::factory('admin/templates/_list')->set('items', $pagination->currentItems);?>
	</tbody>
	
</table>
<?= View::factory('helpers/perpage');?>
<?= $pagination; ?>