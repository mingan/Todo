<div class="lists view">
	<?php
	$class = '';
	if (empty($list['TodoList']['name'])) {
		$class = ' class="empty"';
	}
	?>
	<h1 id="ListName"<?php echo $class; ?>><?php echo h($list['TodoList']['name']); ?></h1>
	<?php
	echo $this->Html->link(
		__('Rename list'),
		array(
			'controller' => 'lists',
			'action' => 'edit',
			$list['TodoList']['id']
		),
		array(
			'id' => 'RenameList'
		)
	);
	?>

	<ul id="ListTasks">
	<?php
	foreach ($list['Task'] as $task) {
		echo $this->element('../Tasks/view', array('task' => $task));
	}
	?>
	</ul>

	<div id="NewTask">
		<h2><?php echo __('New task')?></h2>
		<?php echo $this->element('../Tasks/add', array('listId' => $list['TodoList']['id'])) ?>
	</div>
</div>

<?php echo $this->Html->script('list', array('inline' => false)); ?>