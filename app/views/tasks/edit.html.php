<?=$this->form->create($task, array('url' => array('controller' => 'tasks', 'action' => 'edit', 'id' => $task->id), 'id' => 'EditTask' . $task->id))?>
	<?=$this->form->hidden('id')?>
	<?=$this->form->hidden('list_id')?>
	<?=$this->form->textarea('desc', array('id' => 'TaskDesc'))?>
	<?=$this->form->submit($t('Save')); ?>
<?=$this->form->end()?>