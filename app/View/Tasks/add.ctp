<div class="tasks form">
<?php
echo $this->Form->create('Task', array('url' => array('controller' => 'tasks', 'action' => 'add'), 'id' => 'AddTask'));
echo $this->Form->input('list_hash', array('type' => 'hidden', 'value' => $listHash));
echo $this->Form->input('complete', array('id' => 'TaskDesc', 'class' => 'taskDesc', 'label' => false, 'type' => 'textarea'));
echo $this->Form->end(__('Submit'));
?>
</div>