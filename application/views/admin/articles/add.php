<h1>Nowy artykuł</h1>
<ul class="breadcrumb">
	<li><?= Html::anchor('admin', __('menuPanel')); ?> <span class="divider">/</span></li>
	<li><?= Html::anchor('admin/articles', __('menuNewsList')); ?> <span class="divider">/</span></li>
        <li class="active"><?= __('menuNewsNew'); ?></li>
</ul>
<?= View::factory('admin/articles/_form')
	->set('data', $data)
	->set('errors', $errors); ?>