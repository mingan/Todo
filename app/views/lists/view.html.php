<header>
	<h1><?= $list->name ?></h1>
	<h2 class="timestamp"><?= $t('Last updated'); ?>
		<time datetime="<?php echo $this->time->utc($list->modified); ?>"><?= $this->time->relative($list->modified) ?></time>
	</h2>
</header>
<ul>
<?php
foreach ($list->tasks as $task) {
	$class = 'task';
	if ($task->completed) {
		$class .= ' completed';
	}
?>
	<li data-task_id="<?php echo $task->id ?>" class="<?php echo $class ?>">
		<div class="content">
			<h2 class="taskName"><?= $task->name ?></h2>
			<?php if (!empty($task->desc)) {
				echo '<pre class="taskDesc">' . $h($task->desc) . '</pre>';
			}
			?>
		</div>
		<?php
		echo $this->html->link($t('Edit'), array('controller' => 'tasks', 'action' => 'edit', 'id' => $task->id), array('class' => 'edit'));
		echo $this->html->link($t('Completed'), array('controller' => 'tasks', 'action' => 'complete', 'id' => $task->id), array('class' => 'complete'));
		echo $this->html->link($t('Uncompleted'), array('controller' => 'tasks', 'action' => 'uncomplete', 'id' => $task->id), array('class' => 'uncomplete'));
		echo $this->form->formLink($t('Delete'), array('controller' => 'tasks', 'action' => 'delete', 'id' => $task->id), array('class' => 'delete'));
		?>
	</li>
<?php
}
?>
</ul>
<?php echo $this->_render('element', '../tasks/add', array('listId' => $list->id)) ?>

<?=$this->html->script('list', array('inline' => false))?>