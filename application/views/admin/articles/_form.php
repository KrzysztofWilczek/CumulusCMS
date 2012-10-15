<?= Form::open(null, array('id'=>'article_form')); ?>
<div class="pull-left span3">
<?= Form::label('title', __('labelTitle'));?>
<?= Form::input('title', $data['title']);?>
<?= Form::label('author', __('labelAuthor'));?>
<?= Form::input('author', $data['author']);?>
<label for="is_published" class="checkbox"><?= __('labelPublished'); ?>
<?= Form::checkbox('is_published', '1', TRUE); ?>
</label>
<?= Form::label('publication_date', __('labelPublicationDate'));?>
<div class="input-prepend">
    <span class="add-on"><i class="icon-calendar"></i></span>
    <?= Form::input('publication_date', $data['publication_date'], array('id'=>'publication_date', 'class' => 'span3'));?>
</div>

<?= GoodText::displayErrors('title', $errors);?>
<?= Form::label('brief', __('labelBrief'))?>
<?= Form::textarea('brief', $data['brief']);?>
<div class="info"><?= __('infoBrief'); ?></div>
</div>
<div class="pull-left span6">
<?= Form::label('content', __('labelContent'))?>
<?= Form::textarea('content', $data['content'], array('class' => 'content'));?>
<div class="info"><?= __('infoContent'); ?></div>
</div>
<div class="attached">
<?php if ($files):?>
<?php foreach ($files as $file) :?>
<label class="checkbox"><?= $file->name; ?>
    <?= Form::checkbox('attached[]', $file->id, TRUE); ?>
</label>
<?php endforeach; ?>
<?php endif; ?>
</div>
<div class="filesupload">
    <div class="item span7">
        <div class="fileupload pull-left fileupload-new" data-provides="fileupload">
            <div class="fileupload-preview uneditable-input"></div>
            <span class="btn btn-file"><span class="fileupload-new"><?= __('buttonFileSelect'); ?></span><span class="fileupload-exists"><?= __('buttonChange'); ?></span>
            <input type="file" name="files[]"/></span>
            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?= __('buttonDel'); ?></a>
        </div>
        <div class="toolbox pull-left">
            <a href="#" class="btn add"><?= __('buttonAddNext'); ?></a>
            <a href="#" class="btn del btn-danger"><?= __('buttonDel'); ?></a>
        </div>
    </div>
</div>
<?= Form::submit('submit', __('buttonSave'), array('class'=>'btn btn-danger'));?>
<?= Form::close();?>
<div style="clear:both;"></div>
