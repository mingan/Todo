<div class="lists form">
	<h1><?php echo __('Create new list'); ?></h1>
<?php
echo $this->Form->create('TodoList');
echo $this->Form->input('name');
echo '<h2>' . __('Tasks') . '</h2>';
for ($i = 0; $i < 3; $i++) {
	echo $this->Form->input('Task.' . $i . '.complete', array('type' => 'textarea', 'label' => false, 'class' => 'taskDesc'));
}
echo $this->Form->end(__('Save'));
 ?>
</div>