<!DOCTYPE html>
<html lang="en" >
<head>
	<meta charset=utf-8>
	<meta name="robots" content="index, follow">
	<meta name="author" content="Krzysztof Wilczek" />
	<?php if (!empty($keywords)):?><meta name="keywords" content="<?= $keywords;?>" /><?php endif;?>
	<?php if (!empty($description)):?><meta name="description" content="<?= $description;?>" /><?php endif;?>
	<?php if (!empty($title)):?><title><?= $title;?></title><?php endif;?>
	<?= Html::style('public/css/bootstrap.css');?>
	<?= Less::compile(array(APPPATH.'/less/cms.less'));?>
</head>
<body class="auth">

    <div class="container">
        <div class="well row span5 offset3 ">
            <?= Messenger::show();?>
	    <h1>Cumulus CMS</h1>
            <?= $body;?>
            <?= html::anchor('http://mooncode.eu','Krzysztof Wilczek - MoonCode &copy;', array('class'=>'')); ?><br/>
	    <?= __('labelVersion', array(':version' => '1.0')); ?>
        </div>
    </div>
        
</body>
</html>