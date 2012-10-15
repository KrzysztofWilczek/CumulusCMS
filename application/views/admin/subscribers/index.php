<h1><?= __('menuSubscribers');?></h1>
<ul class="breadcrumb">
	<li><?= Html::anchor('admin', __('menuPanel')); ?> <span class="divider">/</span></li>
	<li class="active"><?= __('menuSubscribersList'); ?></li>
</ul>
<ul class="nav nav-pills">
	<li><a href="/admin/newsletter"><?= __('menuNewsletter'); ?></a></li>
	<li class="active"><a href="#"><?= __('menuSubscribers'); ?></a></li>
</ul>
<table class="table table-striped  table-bordered">
	<thead>
	<tr>
		<th><?=$pagination->sortHeader(__('thEmail'), 'email');?></th>
		<th><?=$pagination->sortHeader(__('thRegistrationDate'), 'registration_date');?></th>
                <th><?= __('thVerification'); ?></th>
		<th></th>
	</tr>
	</thead>
	<tbody id="reloaded">
		<?= View::factory('admin/subscribers/_list')->set('items', $pagination->currentItems);?>
	</tbody>
	
</table>
<?= View::factory('helpers/perpage');?>
<?= $pagination; ?>

<?= View::factory('admin/prompt'); ?>
