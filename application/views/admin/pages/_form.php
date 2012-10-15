<?= Form::open(null, array('id'=>'page_form')); ?>
<div class="pull-left span3">
<?= Form::label('title', __('labelTitle'));?>
<?= Form::input('title', $data['title']);?>
<?= GoodText::displayErrors('title', $errors);?>
<?= Form::label('url', __('labelPageUrl'));?>
<?= Form::input('url', $data['url']);?>
<?= Form::label('keywords', __('labelKeywords'));?>
<?= Form::input('keywords', $data['keywords']);?>
<p><small><?= __('infoKeywords'); ?></small></p>
<?= Form::label('description', __('labelDescription'));?>
<?= Form::input('description', $data['description']);?>
<p><small><?= __('infoDescription'); ?></small></p>
</div>
<div class="pull-left span6">
<?= Form::label('content', __('labelContent'))?>
<?= Form::textarea('content', $data['content']);?>
<div class="info"><?= __('infoContent'); ?><br/>
</div>
<?= Form::submit('submit', __('buttonSave'), array('class'=> 'btn btn-danger'));?>
</div>
<?= Form::close();?>
<div style="clear:both;"></div>