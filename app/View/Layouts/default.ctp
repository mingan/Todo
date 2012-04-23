<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->css(array('default.less?'));
		echo $this->Html->script(array('https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', 'default'));

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="BodyWrap" class="contain">
		<div id="ContentWrap">
			<!--nocache-->
			<?php echo $this->Session->flash(); ?>
			<!--/nocache-->

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="Sidebar">
			<?php echo $this->fetch('sidebar'); ?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
