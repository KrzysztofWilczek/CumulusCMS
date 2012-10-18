<!DOCTYPE html>
<html lang="en" >
<head>
	<meta charset=utf-8>
	<meta name="robots" content="index, follow">
	<meta name="author" content="Krzysztof Wilczek" />
	<link rel="shortcut icon" href="/public/img/admin/favicon.png" />
	<link rel="apple-touch-icon-precomposed" href="/public/img/admin/favicon.png" />
	<?php if (!empty($keywords)):?><meta name="keywords" content="<?= $keywords;?>" /><?php endif;?>
	<?php if (!empty($description)):?><meta name="description" content="<?= $description;?>" /><?php endif;?>
	<?php if (!empty($title)):?><title><?= $title;?></title><?php endif;?>
	<?= Html::style('public/css/reset.css');?>
	<?= Html::style('public/css/bootstrap.css');?>
	<?= Less::compile(array(APPPATH.'/less/cms.less'));?>
	<?= Html::style('public/css/start/jquery-ui-1.8.23.custom.css');?>
	<?= Html::style('public/css/jasny-bootstrap.min.css');?>
	
	<script type="text/javascript" src="/public/js/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="/public/js/jquery-ui-1.8.23.custom.min.js"></script>
	<script type="text/javascript" src="/public/js/bootstrap.js"></script>
	<script type="text/javascript" src="/public/js/bootstrap-fileupload.js"></script>
	<script type="text/javascript" src="/public/js/cms.js"></script>
	<script type="text/javascript" src="/public/js/pagination.js"></script>
</head>
<body>
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="brand" href="/admin/home" target="new">Cumulus CMS</a>
			        <div class="nav-collapse collapse">
					<?= $menu->render(array('class'=>'nav')); ?>
					<p class="navbar-text pull-right">
						<?= __('loggedAs', array(':user' => Session::instance()->get('user')->login));?>
					</p>	
				</div>
				
			</div>
		</div>
	</div>
	<div id="content" class="container-fluid">
		<?= Messenger::show();?>
		<?= $body;?>
	</div>
	<div class="navbar navbar-fixed-bottom">
		<div class="navbar-inner">
			<div class="container-fluid">
				<ul class="nav nav-collapse collapse">
					<li>
						<?= html::anchor('http://mooncode.eu','Krzysztof Wilczek - MoonCode &copy;'); ?>
					</li>
				</ul>
				
				
			</div>
		</div>
	</div>
	
</body>
</html>