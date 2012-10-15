<form action="" method="post" id="search_form" class="form-search pull-right">
	<div class="control-group">
		<div class="controls">
			<div class="input-prepend">
				<span class="add-on"><i class="icon-search"></i></span>
				<input class="span3" name="search_query" value="<?php echo Request::initial()->query('search_query', null);?>" type="text">
			</div>
		</div>
	</div>
	<input type="submit" id="form_submit" value="Search" class="none">
</form>