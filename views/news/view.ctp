	<?php //debug($listNews);?>
	
	<? if ( in_array($session->read('Auth.User.group_id'), array(1,2,3) ) ): ?>
		<p><?php echo $html->link('Добавить новость', array('action'=>'add')); ?></p>
	<? endif ?>
	
	<span class='menulup' >
		<?php echo date( 'd.m.y', strtotime($news['News']['created']) ).' '.$news['News']['name']; ?>
	</span>
		<? if ( in_array($session->read('Auth.User.group_id'), array(1,2,3) ) ): ?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php echo $html->link('Удалить новость', array('action'=>'delete', $news['News']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $news['News']['id'])); ?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php echo $html->link('Редактировать новость', array('action'=>'edit', $news['News']['id'])); ?>
		<? endif ?>		

	<p><?php echo $news['News']['shortbody'].' '.$news['News']['mainbody']; ?></p>
	<br />
	
	<?php foreach($listNews as $list): ?>
	<?php echo $html->link( date( 'd.m.y', strtotime($list['News']['created']) ).' '.$list['News']['name'] , array('controller' => 'News', 'action' => 'view', $list['News']['id']), array('class' => 'menulup') ) ;?>
	<? if ( in_array($session->read('Auth.User.group_id'), array(1,2,3) ) ): ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo $html->link('Удалить новость', array('action'=>'delete', $list['News']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $list['News']['id'])); ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo $html->link('Редактировать новость', array('action'=>'edit', $list['News']['id'])); ?>
	<? endif ?>
	<br />
	<?php echo $html->link( $list['News']['shortbody'], array('controller' => 'News', 'action' => 'view', $list['News']['id']), array('class' => 'menul') ); ?>
	<br />
	<?php endforeach ?>
	
<p>
	<?php echo $html->link('Все новости', array('action'=>'index')); ?>
</p>



