<div class="oauthLinks view">
<h2><?php echo __('Oauth Link'); ?></h2>
	<dl>
		<dt><?php echo __('Oauth Id'); ?></dt>
		<dd>
			<?php echo h($oauthLink['OauthLink']['oauth_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($oauthLink['User']['name'], array('controller' => 'users', 'action' => 'view', $oauthLink['User']['user_id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Oauth Mail'); ?></dt>
		<dd>
			<?php echo h($oauthLink['OauthLink']['oauth_mail']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Oauth Link'), array('action' => 'edit', $oauthLink['OauthLink']['oauth_id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Oauth Link'), array('action' => 'delete', $oauthLink['OauthLink']['oauth_id']), null, __('Are you sure you want to delete # %s?', $oauthLink['OauthLink']['oauth_id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Oauth Links'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Oauth Link'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
