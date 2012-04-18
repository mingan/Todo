<div class="lists view">
	<?php
	$class = '';
	if (empty($list['TodoList']['name'])) {
		$class = ' class="empty"';
	}
	?>
	<h1 id="ListName"<?php echo $class; ?>><?php echo h($list['TodoList']['name']); ?></h1>
	<?php
	if ($private) {
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
	}
	?>

	<ul id="ListTasks">
	<?php
	foreach ($list['Task'] as $task) {
		echo $this->element('../Tasks/view', array('task' => $task, 'private' => $private));
	}
	?>
	</ul>

	<?php
	if ($private) {
	?>
	<div id="NewTask">
		<h2><?php echo __('New task')?></h2>
		<?php echo $this->element('../Tasks/add', array('listId' => $list['TodoList']['id'])) ?>
	</div>
	<?php
	}
	?>
</div>

<?php echo $this->Html->script('list', array('inline' => false)); ?>

<?php
if ($private) {
	$this->start('sidebar');
	?>
	<h2><?php echo __('Your URL'); ?></h2>
	<div class="url"><?php echo $this->Html->link(Router::url(array('controller' => 'lists', 'action' => 'view', $list['TodoList']['hash']), true)); ?></div>

	<h2><?php echo __('URL for sharing'); ?></h2>
	<div class="url"><?php echo $this->Html->link(Router::url(array('controller' => 'lists', 'action' => 'view', $list['TodoList']['public_hash']), true)); ?></div>
	<p><?php echo __('You can use this URL if you want to share your list but don\'t want people to change it.'); ?></p>
	<?php
	$this->end();
}
?>