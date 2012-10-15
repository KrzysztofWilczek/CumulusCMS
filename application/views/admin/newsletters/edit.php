<h1><?= __('menuNewsletterEdit'); ?></h1>
<ul class="breadcrumb">
	<li><?= Html::anchor('admin', __('menuPanel')); ?> <span class="divider">/</span></li>
	<li><?= Html::anchor('admin/newsletter', __('menuNewsletter')); ?> <span class="divider">/</span></li>
        <li class="active"><?= __('menuNewsletterEdit'); ?></li>
</ul>

<?= View::factory('admin/newsletters/_form')
	->set('data', $data)
	->set('errors', $errors); ?>
