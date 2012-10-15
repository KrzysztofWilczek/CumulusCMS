<h1>Edycja szablonu</h1>
<ul class="breadcrumb">
	<li><?= Html::anchor('admin', 'Panel'); ?> <span class="divider">/</span></li>
	<li><?= Html::anchor('admin/templates', 'Lista szablonów'); ?> <span class="divider">/</span></li>
        <li class="active">Edycja szablonu</li>
</ul>
<?= Form::open(null, array('id'=>'mail_template_form')); ?>
<div class="pull-left span3">
<?= Form::label('name', 'Nazwa');?>
<?= Form::input('name', $data['name']);?>
<?= Form::label('code', 'Nazwa kodowa');?>
<?= Form::input('code', $data['code']);?>
<?= GoodText::displayErrors('code', $errors);?>
<?php if (!empty($data['tags'])): ?>
<div class="info">W szablonie można wykorzystać następujące tagi:<br/>
	<?= Model_Template::showTagsList($data['tags']);?>
</div>
<?php endif;?>
</div>
<div class="pull-left span3">
<?= Form::label('content', 'Treść')?>
<?= Form::textarea('content', $data['content']);?>
<div class="info">Treść szablonu może zawierać formatowanie.</div>
<?= Form::submit('submit', 'Zapisz', array('class'=> 'btn btn-danger'));?>
</div>
<?= Form::close();?>
<div style="clear:both;"></div>