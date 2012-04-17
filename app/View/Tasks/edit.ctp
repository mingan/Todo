<div class="tasks form">
<?php echo $this->Form->create('Task', array('url' => array('controller' => 'tasks', 'action' => 'edit', $this->data['Task']['id']), 'id' => 'EditTask' . $this->data['Task']['id']));?>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('list_id', array('type' => 'hidden'));
		echo $this->Form->input('complete', array('label' => false, 'type' => 'textarea'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Save'));?>
</div>