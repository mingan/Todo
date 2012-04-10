
	<?=$this->form->hidden('list_id', array('value' => $listId))?>
	<?=$this->form->text('name')?>
	<?=$this->form->textarea('desc')?>
	<?=$this->form->submit($t('Save')); ?>