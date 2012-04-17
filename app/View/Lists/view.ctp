<div class="lists view">
	<h1><?php echo h($list['TodoList']['name']); ?></h1>

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