<h1><?= __('menuNewsletter'); ?></h1>
<ul class="breadcrumb">
	<li><?= Html::anchor('admin', __('menuPanel')); ?> <span class="divider">/</span></li>
	<li class="active"><?= __('menuNewsletterList'); ?></li>
</ul>
<?= Html::anchor('admin/newsletter/add', '<i class="icon-plus-sign icon-white"></i> '.__('buttonNewsletterAdd'), array('class' => 'pull-right btn btn-danger')); ?>
<?= View::factory('helpers/search');?>
<ul class="nav nav-pills">
	<li class="active"><a href="#"><?= __('menuNewsletter'); ?></a></li>
	<li><a href="/admin/subscribers"><?= __('menuSubscribers'); ?></a></li>
</ul>
<table class="table table-striped  table-bordered">
	<thead>
	<tr>		
		<th><?=$pagination->sortHeader(__('thTitle'), 'title');?></th>
		<th><?= __('thStatus'); ?></th>
                <th><?=$pagination->sortHeader(__('thRecipients'), 'title');?></th>
		<th><?=$pagination->sortHeader(__('thSendDate'), 'send_date');?></th>
		<th><?=$pagination->sortHeader(__('thLastModification'), 'modification_date');?></th>
		<th></th>
	</tr>
	</thead>
	<tbody id="reloaded">
		<?= View::factory('admin/newsletters/_list')->set('items', $pagination->currentItems);?>
	</tbody>

</table>
<?= View::factory('helpers/perpage');?>
<?= $pagination; ?>

<?= View::factory('admin/prompt'); ?>
