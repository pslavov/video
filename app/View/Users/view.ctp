<div class="users view">
<h2><?php echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('User Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['user_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($user['User']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($user['User']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created At'); ?></dt>
		<dd>
			<?php echo h($user['User']['created_at']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Active'); ?></dt>
		<dd>
			<?php echo h($user['User']['is_active']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['user_id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['user_id']), null, __('Are you sure you want to delete # %s?', $user['User']['user_id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Oauth Links'), array('controller' => 'oauth_links', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Oauth Link'), array('controller' => 'oauth_links', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Oauth Links'); ?></h3>
	<?php if (!empty($user['OauthLink'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Oauth Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Oauth Mail'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['OauthLink'] as $oauthLink): ?>
		<tr>
			<td><?php echo $oauthLink['oauth_id']; ?></td>
			<td><?php echo $oauthLink['user_id']; ?></td>
			<td><?php echo $oauthLink['oauth_mail']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'oauth_links', 'action' => 'view', $oauthLink['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'oauth_links', 'action' => 'edit', $oauthLink['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'oauth_links', 'action' => 'delete', $oauthLink['id']), null, __('Are you sure you want to delete # %s?', $oauthLink['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Oauth Link'), array('controller' => 'oauth_links', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
