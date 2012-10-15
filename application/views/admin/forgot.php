<?= Form::open(null);?>
<blockquote><?= __('quoteForgot'); ?></blockquote>
<?= Form::label('login', __('labelLogin')); ?>
<?= Form::input('login', '', array('class'=>'span5')); ?>
<p class="pull-right">
<?= Html::anchor('admin/login', __('buttonLogin'),array('class'=>'btn'));?> 
<?= Form::submit('submit_forgot', __('buttonRemind'),array('class'=>'btn btn-danger'));?> 
</p>
<?= Form::close();?>
<div style="clear: both;"></div>