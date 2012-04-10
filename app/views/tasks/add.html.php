<?php
if (empty($listId)) {
	$listId = null;
}
?>

<?=$this->form->create(null, array('url' => array('controller' => 'tasks', 'action' => 'add'), 'id' => 'AddTask'))?>
<?php echo $this->_render('element', '../tasks/_form');?>
<?=$this->form->end()?>