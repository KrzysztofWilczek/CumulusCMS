<?= Form::open(null, array('id'=>'login_form'));?>
<?= Form::label('login', __('labelLogin'));?>
<?= Form::input('login', $data['login'], array('id' => 'login', 'class'=>'span5'));?>
<?= Form::label('password', __('labelPassword'));?>
<?= Form::password('password', $data['password'], array('id' => 'password', 'class'=>'span5'));?>
<p class="pull-right">
<?= Html::anchor('/admin/forgot', __('buttonForgot'), array('class'=>'btn'));?> 
<?= Form::submit('submit_login', __('buttonLogin'),array('class'=>'btn btn-danger'));?> 
</p>
<div style="clear: both;"></div>
<?= Form::close();?>

			
    

