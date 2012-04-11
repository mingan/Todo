<?php
	$class = 'task contain';
	if ($task->completed) {
		$class .= ' completed';
	}
?>
	<li data-task_id="<?php echo $task->id ?>" class="<?php echo $class ?>">
		<?php
			echo $this->html->link('✔', array('controller' => 'tasks', 'action' => 'complete', 'id' => $task->id), array('class' => 'complete', 'title' => $t('Complete')));
			echo $this->html->link('✔', array('controller' => 'tasks', 'action' => 'uncomplete', 'id' => $task->id), array('class' => 'uncomplete', 'title' => $t('Uncomplete')));
		?>
		<div class="content">
			<h2 class="taskName"><?= $task->name ?></h2>
			<?php if (!empty($task->desc)) {
				echo '<pre class="taskDesc">' . $h($task->desc) . '</pre>';
			}
			?>
		</div>
		<div class="links">
			<?php
			echo $this->html->link($t('Edit'), array('controller' => 'tasks', 'action' => 'edit', 'id' => $task->id), array('class' => 'edit', 'title' => $t('Edit')));
			echo $this->form->formLink($t('Delete'), array('controller' => 'tasks', 'action' => 'delete', 'id' => $task->id), array('class' => 'delete', 'title' => $t('Delete')));
			?>
		</div>
	</li>