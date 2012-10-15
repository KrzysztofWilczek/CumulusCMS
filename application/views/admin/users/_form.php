<?= Form::open(null, array('id'=>'user_form', 'enctype' => 'multipart/form-data' )); ?>

<div class="pull-left">
<?= Form::label('avatar', __('labelAvatar'));?>
<div class="fileupload fileupload-new avatar" data-provides="fileupload">
	<div class="fileupload-new thumbnail"><img src="http://placehold.it/150x150" /></div>
	<div class="fileupload-preview fileupload-exists thumbnail"></div>
	<div>
		<span class="btn btn-file"><span class="fileupload-new"><?= __('buttonSelect'); ?></span><span class="fileupload-exists">Zmień</span><?= Form::file('avatar');?></span>
		<a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?= __('buttonDel'); ?></a>
	</div>
</div>
</div>
<div class="pull-left span3">
<?= Form::label('login', __('labelLogin'));?>
<?= Form::input('login', $data['login']);?>
<?= GoodText::displayErrors('login', $errors);?>

<?php if ($add): ?>
<?= Form::label('password', __('labelPassword'));?>
<?= Form::password('password', $data['password']);?>
<?= GoodText::displayErrors('password', $errors);?>
<?= Form::label('password_repeat', __('labelPasswordRepeat'));?>
<?= Form::password('password_repeat', $data['password_repeat']);?>
<?= GoodText::displayErrors('password_repeat', $errors);?>
<?php endif; ?>
<?= Form::label('email', __('labelEmail'));?>
<?= Form::input('email', $data['email']);?>
<?= GoodText::displayErrors('email', $errors);?>
<?= Form::label('role', __('labelType'));?>
<?= Form::select('role', Model_User::$rolesNames, 1);?>
<?= Form::submit('submit', __('buttonSave'), array('class'=>'btn btn-danger'));?>
</div>
<?= Form::close();?>

<div style="clear:both;"></div>
