<div class="users view">
<h2><?php echo $session->read('Auth.User.username');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
			<p><?php echo $html->link('Редактировать', array('action'=>'edit', $user['User']['id'])); ?> </p>
			<p><?php echo $html->link('Изменить пароль', array('action'=>'newpassword', $user['User']['id'])); ?> </p>

		<hr />
		<dt<?php if ($i % 2 == 0) echo $class;?>>Логин:</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['username']; ?>
			&nbsp;
		</dd>
		<hr />
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['email']; ?>
			&nbsp;
		</dd>
		<hr />
		<dt<?php if ($i % 2 == 0) echo $class;?>>Контактное лицо:</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['contact']; ?>
			&nbsp;
		</dd>
		<hr />
		<dt<?php if ($i % 2 == 0) echo $class;?>>Телефон:</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['phone']; ?>
			&nbsp;
		</dd>
		<hr />
		<dt<?php if ($i % 2 == 0) echo $class;?>>Компания:</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['company']; ?>
			&nbsp;
		</dd>
		<hr />
		
		<dt<?php if ($i % 2 == 0) echo $class;?>>Сфера деятельности:</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['business']; ?>
			&nbsp;
		</dd>
		<hr />		
		
		<dt<?php if ($i % 2 == 0) echo $class;?>>Факс:</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['fax']; ?>
			&nbsp;
		</dd>
		<hr />		
		
		<dt<?php if ($i % 2 == 0) echo $class;?>>Адрес сайта:</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['website']; ?>
			&nbsp;
		</dd>
		<hr />
		
		<dt<?php if ($i % 2 == 0) echo $class;?>>Юридический адрес:</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['address1']; ?>
			&nbsp;
		</dd>
		<hr />
		
		<dt<?php if ($i % 2 == 0) echo $class;?>>Фактический адрес:</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['address2']; ?>
			&nbsp;
		</dd>
		<hr />
		
		<dt<?php if ($i % 2 == 0) echo $class;?>>Банковские реквизиты:</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['bank_detail']; ?>
			&nbsp;
		</dd>
		<hr />
				
	</dl>
</div>