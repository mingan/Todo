<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2011, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
?>
<!doctype html>
<html>
<head>
	<?php echo $this->html->charset();?>
	<title>Todo > <?php echo $this->title(); ?></title>
	<?php echo $this->html->style(array('default.less?')); ?>
	<?php echo $this->html->script(array('default', 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js')); ?>
	<?php echo $this->scripts(); ?>
	<?php echo $this->html->link('Icon', null, array('type' => 'icon')); ?>
</head>
<body>
	<div id="BodyWrap">
		<div id="ContentWrap">
			<?php echo $this->content(); ?>
		</div>
	</div>

	<?= $this->_render('element', 'dump') ?>
</body>
</html>