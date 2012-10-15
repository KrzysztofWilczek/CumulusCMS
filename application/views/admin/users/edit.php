<h1><?= __('menuUsersEdit'); ?></h1>
<ul class="breadcrumb">
	<li><?= Html::anchor('admin', __('menuPanel')); ?> <span class="divider">/</span></li>
	<li><?= Html::anchor('admin/users', __('menuUsersList')); ?> <span class="divider">/</span></li>
        <li class="active"><?= __('menuUsersEdit'); ?></li>
</ul>

<?= View::factory('admin/users/_form')
	->set('data', $data)
	->set('errors', $errors); ?>
