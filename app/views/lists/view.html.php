<header>
	<h1><?= $list->name ?></h1>
	<h2><?= $t('Last updated'); ?>
		<time datetime="<?php echo $this->time->utc($list->modified); ?>"><?= $this->time->relative($list->modified) ?></time>
	</h2>
</header>
<ul>
<?php
foreach ($list->tasks as $task) {
	$class = '';
	if ($task->completed) {
		$class = ' class="completed"';
	}
?>
	<li data-task_id="<?php echo $task->id ?>"<?php echo $class ?>>
	<h2><?= $task->name ?></h2>
	<?php if (!empty($task->desc)) {
		echo '<div class="desc">' . $h($task->desc) . '</div>';
	}
	?>
	</li>
<?php
}
?>
</ul>
<?=$this->form->create(null, array('url' => array('controller' => 'tasks', 'action' => 'add'), 'id' => 'AddTask'))?>
	<?=$this->form->hidden('list_id', array('value' => $list->id))?>
	<?=$this->form->text('name')?>
	<?=$this->form->textarea('desc')?>
	<?=$this->form->submit($t('Add')); ?>
<?=$this->form->end()?>

<?=$this->html->script('list', array('inline' => false))?>