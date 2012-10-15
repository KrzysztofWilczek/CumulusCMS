<h1><?= __('menuUsersNew'); ?></h1>
<ul class="breadcrumb">
	<li><?= Html::anchor('admin', __('menuPanel')); ?> <span class="divider">/</span></li>
	<li><?= Html::anchor('admin/users', __('menuUsersList')); ?> <span class="divider">/</span></li>
        <li class="active"><?= __('menuUsersNew'); ?></li>
</ul>

<?= View::factory('admin/users/_form')
	->set('data', $data)
	->set('add', true)
	->set('errors', $errors); ?>
