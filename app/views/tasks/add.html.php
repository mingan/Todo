<?=$this->form->create(null, array('url' => array('controller' => 'tasks', 'action' => 'add'), 'id' => 'AddTask'))?>
	<?=$this->form->hidden('list_id', array('value' => $listId))?>
	<?=$this->form->textarea('desc', array('id' => 'TaskDesc'))?>
	<?=$this->form->submit($t('Save')); ?>
<?=$this->form->end()?>