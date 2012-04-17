<div class="lists form">
	<h1><?php echo __('Rename List'); ?></h1>
<?php echo $this->Form->create('TodoList');?>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('id');
	?>
<?php echo $this->Form->end(__('Submit'));?>
</div>