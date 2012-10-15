<!DOCTYPE html>
<html lang="en" >
<head>
	<meta charset=utf-8>
	<meta name="robots" content="index, follow">
	<meta name="author" content="Krzysztof Wilczek" />
	<link rel="shortcut icon" href="/public/img/favicon.png" />
	<link rel="apple-touch-icon-precomposed" href="/public/img/apple_touch_icon.png" />
	<?php if (!empty($keywords)):?><meta name="keywords" content="<?= $keywords;?>" /><?php endif;?>
	<?php if (!empty($description)):?><meta name="description" content="<?= $description;?>" /><?php endif;?>
	<?php if (!empty($title)):?><title><?= $title;?></title><?php endif;?>
	<?= Html::script('public/js/mootools.js');?>
	<?= Html::script('public/js/mootools-more.js');?>
	<?= Html::script('public/js/dotsdock.js');?>
	<?= Html::script('public/js/TabPane.js');?>
	<?= Html::script('public/js/TabPane.Extra.js');?>
	
	<?= Html::style('public/css/reset.css');?>
	<?= Less::compile(array(APPPATH.'/less/style.less'));?>

</head>
<body>

<div id="pageHeader">
	<div class="content">
		<a href="/" id="logo"></a>
		<div id="sun"></div>
	</div>
</div>
<?= $body;?>
<div id="pageFooter">
	<div class="content">
		<div class="left">
			BazaUrlopowa.pl &copy; 2012<br/>
			<a href="" target="new">Facebook</a> | <a href="" target="new">Google+</a> | <a href="" target="new">Twitter</a>
		</div>
		<div class="right">
			 <?= html::anchor('/','Strona Główna'); ?> | <a href="">Wyszukaj</a> | <a href="">Forum</a> | <a href="">Kontakt</a> | <a href="">Regulamin</a>
		</div>
		<div style="clear: both;"></div>
	</div>
</div>

</body>

</html>