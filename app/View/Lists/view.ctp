<div class="lists view">
<h2><?php  echo __('List');?></h2>
	<dl>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($list['List']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($list['List']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($list['List']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($list['List']['id']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit List'), array('action' => 'edit', $list['List']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete List'), array('action' => 'delete', $list['List']['id']), null, __('Are you sure you want to delete # %s?', $list['List']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Lists'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New List'), array('action' => 'add')); ?> </li>
	</ul>
</div>
