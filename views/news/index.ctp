<br /><br /> 
<?php if( isset($this->params['paging']['News']['pageCount']) && $this->params['paging']['News']['pageCount'] > 1 ): ?>
<div class="paging">
	<?php echo $paginator->sort('Сортировать по дате','created');?>
	<table>
		<tr>
			<td><?php echo $paginator->prev('Назад', array(), null, array('class'=>'disabled'));?></td>
  			<td><?php echo $paginator->numbers();?></td>
			<td><?php echo $paginator->next('Вперед', array(), null, array('class'=>'disabled'));?></td>
		</tr>
	</table>
</div>
<?php endif ?>	
	
	<?php foreach($listNews as $list): ?>
	<?php echo $html->link( date( 'd.m.y', strtotime($list['News']['created']) ).' '.$list['News']['name'] , array('controller' => 'News', 'action' => 'view', $list['News']['id']), array('class' => 'header_news') ) ;?>
	<? if ( in_array($session->read('Auth.User.group_id'), array(1,2,3) ) ): ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo $html->link('Удалить новость', array('action'=>'delete', $list['News']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $list['News']['id'])); ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo $html->link('Редактировать новость', array('action'=>'edit', $list['News']['id'])); ?>
	<? endif ?>
	<br />
	<?php echo $html->link( $list['News']['shortbody'], array('controller' => 'News', 'action' => 'view', $list['News']['id']), array('class' => 'body_news') ); ?>
	<br />
	<br />
	<?php endforeach ?>

	<? if ( in_array($session->read('Auth.User.group_id'), array(1,2,3) ) ): ?>
		<p><?php echo $html->link('Добавить новость', array('action'=>'add')); ?></p>
	<? endif ?>
	
