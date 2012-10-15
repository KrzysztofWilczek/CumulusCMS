<h1>Edycja artykułu</h1>
<ul class="breadcrumb">
	<li><?= Html::anchor('admin', 'Panel'); ?> <span class="divider">/</span></li>
	<li><?= Html::anchor('admin/articles', 'Lista artykułów'); ?> <span class="divider">/</span></li>
        <li class="active">Edycja artykułu</li>
</ul>

<?= View::factory('admin/articles/_form')
	->set('data', $data)
	->set('errors', $errors); ?>