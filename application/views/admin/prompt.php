
<div class="modal" id="modalPrompt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel"><?= __('modalWarning'); ?></h3>	
	</div>
	<div class="modal-body">
		<p><?= __('modalWarningText'); ?></p>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true"><?= __('buttonCancel'); ?></button>
		 <button class="btn btn-danger" id="modalPromptDo"><?= __('buttonDel'); ?></button>
	</div>
</div>