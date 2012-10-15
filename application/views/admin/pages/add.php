<h1><?= __('menuPagesNew'); ?></h1>
<ul class="breadcrumb">
	<li><?= Html::anchor('admin', __('menuPanel')); ?> <span class="divider">/</span></li>
	<li><?= Html::anchor('admin/pages', __('menuPagesList')); ?> <span class="divider">/</span></li>
        <li class="active"><?= __('menuPagesNew'); ?></li>
</ul>

<?= View::factory('admin/pages/_form')
	->set('data', $data)
	->set('errors', $errors); ?>
