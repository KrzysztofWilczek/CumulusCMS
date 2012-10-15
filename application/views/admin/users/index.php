<h1><?= __('menuUsers'); ?></h1>
<ul class="breadcrumb">
	<li><?= Html::anchor('admin', __('menuPanel')); ?> <span class="divider">/</span></li>
	<li class="active"><?= __('menuUsersList'); ?></li>
</ul>
<?= Html::anchor('admin/users/add', '<i class="icon-plus-sign icon-white"></i> '.__('buttonUsersAdd'), array('class' => 'pull-right btn btn-danger')); ?>
<?= View::factory('helpers/search');?>
<blockquote><?= __('quoteUsers'); ?></blockquote>

<table class="table table-striped  table-bordered">
    <col width="60px"/>
	<thead>
	<tr>
		<th colspan="2"><?=$pagination->sortHeader(__('thUser'), 'login');?></th>
		<th><?=$pagination->sortHeader(__('thRegistrationDate'), 'registration_date');?></th>
		<th><?=$pagination->sortHeader(__('thType'), 'role');?></th>
		<th></th>
	</tr>
	</thead>
	<tbody id="reloaded">
		<?= View::factory('admin/users/_list')->set('items', $pagination->currentItems);?>
	</tbody>
		
</table>
<?= View::factory('helpers/perpage');?>
<?= $pagination; ?>

<?= View::factory('admin/prompt'); ?>
