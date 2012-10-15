<?= Form::open(null, array('id'=>'newsletter_form')); ?>
<div class="pull-left span3">
<?= Form::label('title', __('labelTitle'));?>
<?= Form::input('title', $data['title']);?>
<?= GoodText::displayErrors('title', $errors);?>
<?= Form::label('send_date', __('labelSendDate'));?>
<div class="input-prepend">
    <span class="add-on"><i class="icon-calendar"></i></span>
    <?= Form::input('send_date', $data['send_date'], array('id'=>'publication_date'));?>
</div>
</div>
<div class="pull-left span6">
<?= Form::label('content', __('labelContent'))?>
<?= Form::textarea('content', $data['content']);?>
<div class="info"><?= __('infoContent'); ?></div>
<?= Form::submit('submit', __('buttonSave'), array('class'=>'btn btn-danger'));?>
</div>
<?= Form::close();?>
<div style="clear:both;"></div>