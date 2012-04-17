<div class="lists view">
	<h1><?php echo h($list['TodoList']['name']); ?></h1>

	<ul id="ListTasks">
	<?php
	foreach ($list['Task'] as $task) {
		$class = 'task contain';
		if ($task['completed']) {
			$class .= ' completed';
		}
		?>
		<li data-task_id="<?php echo $task['id'] ?>" class="<?php echo $class ?>">
		<?php
		echo $this->element('../Tasks/view', array('task' => $task));
		?>
		</li>
		<?php
	}
	?>
	</ul>
</div>