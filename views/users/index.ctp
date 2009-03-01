<div class="users index">
<h3><?php echo $html->link('Пользователи',array('controller'=>'users','action'=>'index','u:customer') );?></h3>
<h4><?php echo $html->link('Администраторы',array('controller'=>'users','action'=>'index','u:admin') );?></h4>
<p>
	<?php
	echo $paginator->counter(array(
	'format' => __('Страница %page% из %pages%, Всего %count% пользователей', true)
	));
	?>
</p>
<table cellpadding="3" cellspacing="3">
	<tr>
		<th><?php echo $paginator->sort('Логин','name');?></th>
		<th><?php echo $paginator->sort('Статус','Group.name');?></th>
		<th><?php echo $paginator->sort('Email','email');?></th>
		<th><?php echo $paginator->sort('Контактное лицо','contact');?></th>
		<th><?php echo $paginator->sort('Дата регистрации','contact');?></th>
		<th class="actions">Действия</th>
	</tr>
	<?php
		$i = 0;
		foreach ($users as $user):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
	?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $user['User']['username']; ?>
		</td>
		<td>
			<?php echo $user['Group']['name']; ?>
		</td>
		<td>
			<?php echo $user['User']['email']; ?>
		</td>
		<td>
			<?php echo $user['User']['contact']; ?>
		</td>
		<td>
			<?php echo date( 'd.m.y', strtotime($user['User']['created']) ); ?>
		</td>
		<td class="actions">
			<p class="actions"><?php echo $html->link(__('Просмотр', true), array('action'=>'view', $user['User']['id'])); ?></p>
			<p class="actions"><?php echo $html->link(__('Редактирование', true), array('action'=>'edit', $user['User']['id'])); ?></p>
			<p class="actions"><?php echo $html->link(__('Удаление', true), array('action'=>'delete', $user['User']['id']), null, sprintf(__('Удалить пользователя # %s?', true), $user['User']['id'])); ?></p>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
	<div class="page">
	<?php 
		$paginator->options(array('url' => $this->passedArgs)); 
	?>
			<?php if( isset($this->params['paging']['User']['pageCount']) && $this->params['paging']['User']['pageCount'] > 1 ): ?>
				<?php echo $paginator->prev('Назад', array( 'class' => 'menu2' ) , null,  array('class'=>'menu2'));?>
  				<?php echo $paginator->numbers( array('modulus'=>'5','separator'=>' ', 'class' => 'menu2' ), null );?>
				<?php echo $paginator->next('Вперед', array( 'class' => 'menu2' ), null, array('class'=>'menu2'));?>
			<?php endif ?>

	</div>


