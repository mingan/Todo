<?=$this->form->create($task, array('url' => array('controller' => 'tasks', 'action' => 'edit', 'id' => $task->id), 'id' => 'EditTask' . $task->id))?>
<?=$this->form->hidden('id')?>
<?php echo $this->_render('element', '../tasks/_form', array('listId' => null));?>
<?=$this->form->end()?>