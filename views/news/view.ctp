<br /><br />
	
	<? if ( in_array($session->read('Auth.User.group_id'), array(1,2,3) ) ): ?>
		<p><?php echo $html->link('Добавить новость', array('action'=>'add'), array('class' => 'header_news')); ?></p>
	<br/><br/>
	<? endif ?>
	
	<div class="header_news">
		<?php echo date( 'd.m.y', strtotime($news['News']['created']) ).' '.$news['News']['name']; ?>
	</div>
		<? if ( in_array($session->read('Auth.User.group_id'), array(1,2,3) ) ): ?>
			<br/>
			<?php echo $html->link('Удалить новость', array('action'=>'delete', $news['News']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $news['News']['id'])); ?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php echo $html->link('Редактировать новость', array('action'=>'edit', $news['News']['id'])); ?>
		<br/><br/>
		<? endif ?>		

	<div class="body_news"><?php echo $news['News']['shortbody'].' '.$news['News']['mainbody']; ?>
		<br /><br />
		<hr>
	</div><br /><br />
	
	<?php foreach($listNews as $list): ?>
	<div class="header_news_all">
		<?php echo $html->link( date( 'd.m.y', strtotime($list['News']['created']) ).' '.$list['News']['name'] , array('controller' => 'News', 'action' => 'view', $list['News']['id']), array('class' => 'header_news_all') ) ;?>
	</div>
	
	<? if ( in_array($session->read('Auth.User.group_id'), array(1,2,3) ) ): ?>
		<br/>
		<?php echo $html->link('Удалить новость', array('action'=>'delete', $list['News']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $list['News']['id'])); ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo $html->link('Редактировать новость', array('action'=>'edit', $list['News']['id'])); ?>
	<br/><br/>
	<? endif ?>
	<div class="body_news">
		<?php echo $html->link( $list['News']['shortbody'], array('controller' => 'News', 'action' => 'view', $list['News']['id']), array('class' => 'body_news') ); ?>
	</div>
	<br />
	<br />
	<?php endforeach ?>
	
<p>
	<?php echo $html->link('Все новости', array('action'=>'index'), array('class' => 'header_news')); ?>
</p>



