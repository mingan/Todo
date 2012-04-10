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
		echo '<pre class="desc">' . $h($task->desc) . '</pre>';
	}
	echo $this->html->link($t('Edit'), array('controller' => 'tasks', 'action' => 'edit', 'id' => $task->id), array('class' => 'edit'));
	echo $this->html->link($t('Completed'), array('controller' => 'tasks', 'action' => 'completed', 'id' => $task->id), array('class' => 'completed'));
	echo $this->html->link($t('Uncompleted'), array('controller' => 'tasks', 'action' => 'uncompleted', 'id' => $task->id), array('class' => 'uncompleted'));
	echo $this->form->formLink($t('Delete'), array('controller' => 'tasks', 'action' => 'delete', 'id' => $task->id), array('class' => 'delete'));
	?>
	</li>
<?php
}
?>
</ul>
<?php echo $this->_render('element', '../tasks/add', array('listId' => $list->id)) ?>

<?=$this->html->script('list', array('inline' => false))?>