<?php
if (isset($task)) {
	$task = $task;
}

echo $this->Html->link('✔', array('controller' => 'tasks', 'action' => 'complete', $task['id']), array('class' => 'complete', 'title' => __('Complete')));
echo $this->Html->link('✔', array('controller' => 'tasks', 'action' => 'uncomplete', $task['id']), array('class' => 'uncomplete', 'title' => __('Uncomplete')));
?>
<div class="content">
	<h2 class="taskName"><?php echo h($task['name']) ?></h2>
	<pre class="taskDesc"><?php echo h($task['desc'])?></pre>
</div>
<div class="links">
	<?php
	echo $this->Html->link(__('Edit'), array('controller' => 'tasks', 'action' => 'edit', $task['id']), array('class' => 'edit', 'title' => __('Edit')));
	echo $this->Form->postLink(__('Delete'), array('controller' => 'tasks', 'action' => 'delete', $task['id']), array('class' => 'delete', 'title' => __('Delete')));
	?>
</div>

<?php echo $this->Html->script('list', array('inline' => false)); ?>