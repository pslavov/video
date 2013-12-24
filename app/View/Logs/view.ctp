<div class="logs view">
<h2><?php echo __('Log'); ?></h2>
	<dl>
		<dt><?php echo __('Log Id'); ?></dt>
		<dd>
			<?php echo h($log['Log']['log_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User Id'); ?></dt>
		<dd>
			<?php echo h($log['Log']['user_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Controler'); ?></dt>
		<dd>
			<?php echo h($log['Log']['controler']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Action'); ?></dt>
		<dd>
			<?php echo h($log['Log']['action']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($log['Log']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ip'); ?></dt>
		<dd>
			<?php echo h($log['Log']['ip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created_at'); ?></dt>
		<dd>
			<?php echo h($log['Log']['created_at']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Log'), array('action' => 'edit', $log['Log']['log_id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Log'), array('action' => 'delete', $log['Log']['log_id']), null, __('Are you sure you want to delete # %s?', $log['Log']['log_id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Logs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Log'), array('action' => 'add')); ?> </li>
	</ul>
</div>
